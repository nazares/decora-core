<?php

/**
 * User: nazareS
 * Date: 5/07/2023
 * Time: 5:12 PM
 */

namespace nazares\decoracore;

use nazares\decoracore\middlewares\BaseMiddleware;

/**
 * Class Controller
 *
 * @author Sergei Nazarenko <nazares@icloud.com>
 * @package nazares\decoracore
 */
class Controller
{
    public string $layout = 'main';
    public string $action = '';
    /**
     *
     * @var nazares\decoracore\middlewares\BaseMiddleware[]
     */
    protected array $middlewares = [];

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function render($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function registerMidleware(BaseMiddleware $middleware): void
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * Get the value of middlewares
     *
     * @return  nazares\decoracore\middlewares\BaseMiddleware[]
     */
    public function getMiddlewares()
    {
        return $this->middlewares;
    }
}
