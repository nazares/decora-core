<?php

namespace nazares\decoracore;

use nazares\decoracore\db\Database;

/**
 * Class Application
 *
 * @author Sergei Nazarenko <nazares@icloud.com>
 * @package nazares\decoracore
 */
class Application
{
    public const EVENT_BEFORE_REQUEST = 'beforeRequest';
    public const EVENT_AFTER_REQUEST = 'afterRequest';

    protected array $eventListeners = [];

    public static string $ROOT_DIR;

    public string $layout = 'main';
    public string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Database $db;
    public ?UserModel $user;
    public View $view;

    public static Application $app;
    public ?Controller $controller = null;
    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;

        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->view = new View();

        $this->db = new Database($config['db']);

        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }

    public function run()
    {
        $this->triggerEvent(self::EVENT_BEFORE_REQUEST);
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            $this->response->setStatusCode((int)$e->getCode());
            echo $this->view->renderView('_error', [
                'exception' => $e
            ]);
        }
    }

    /**
     * Get the value of controller
     * @return \nazares\decoracore\Controller
     */
    public function getController(): \nazares\decoracore\Controller
    {
        return $this->controller;
    }

    /**
     * Set the value of controller
     *
     * @param \nazares\decoracore\Controller $controller
     */
    public function setController(\nazares\decoracore\Controller $controller): void
    {
        $this->controller = $controller;
    }

    public function login(UserModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public function triggerEvent($eventName)
    {
        $callbacks = $this->eventListeners[$eventName] ?? [];
        foreach ($callbacks as $callback) {
            call_user_func($callback);
        }
    }



    public function on($eventName, $callback): void
    {
        $this->eventListeners[$eventName][] = $callback;
    }
}
