<?php

/**
 * User: nazareS
 * Date: 5/07/2023
 * Time: 10:54 AM
 */

namespace nazares\decora-core;

use nazares\decora-core\exception\NotFoundException;

/**
 * Class Router
 *
 * @author Sergei Nazarenko <nazares@icloud.com>
 * @package nazares\decora-core
 */
class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];
    /**
     * Router constructor
     *
     * @param \nazares\decora-core\Request $request
     * @param \nazares\decora-core\Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            throw new NotFoundException();
        }
        if (is_string($callback)) {
            return Application::$app->view->renderView($callback);
        }
        if (is_array($callback)) {
            /** @var \nazares\decora-core\Controller $controller */
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;

            foreach ($controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }
        }

        return call_user_func($callback, $this->request, $this->response);
    }
}
