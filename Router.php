<?php

/**
 * User: nazareS
 * Date: 5/07/2023
 * Time: 10:54 AM
 */

namespace nazares\decoracore;

use nazares\decoracore\exception\NotFoundException;

/**
 * Class Router
 *
 * @author Sergei Nazarenko <nazares@icloud.com>
 * @package nazares\decoracore
 */
class Router
{
    public Request $request;
    public Response $response;
    protected array $routeMap = [];
    /**
     * Router constructor
     *
     * @param \nazares\decoracore\Request $request
     * @param \nazares\decoracore\Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routeMap['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routeMap['post'][$path] = $callback;
    }

    public function getRouteMap($method): array
    {
        return $this->routeMap[$method] ?? [];
    }

    public function getCallback(): ?callable
    {
        $method = $this->request->method();
        $path = $this->request->getPath();
        $path = trim($path, '/');
        $routes = $this->getRouteMap($method);
        $routeParams = false;

        foreach ($routes as $route => $callback) {
            $route = trim($route, '/');
            $routeNames = [];
            if (!$route) {
                continue;
            }

            if (preg_match_all('/\{(\w+)(:[^}]+)?}/', $route, $matches)) {
                $routeNames = $matches[1];
            }
            $routeRegex = "@^" . preg_replace_callback(
                '/\{\w+(:([^}]+))?}/',
                fn ($m) => isset($m[2]) ? "({$m[2]})" : '(\w+)',
                $route
            ) . "$@";
            if (preg_match_all($routeRegex, $path, $valueMatches)) {
                $values = [];
                for ($i = 1; $i < count($valueMatches); $i++) {
                    $values[] = $valueMatches[$i][0];
                }
                $routeParams = array_combine($routeNames, $values);
                $this->request->setRouteParams($routeParams);
                return $callback;
            }
        }
        return null;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routeMap[$method][$path] ?? false;
        if (!$callback) {
            $callback = $this->getCallback();
            if ($callback === false) {
                throw new NotFoundException();
            }
        }
        if (is_string($callback)) {
            return Application::$app->view->renderView($callback);
        }
        if (is_array($callback)) {
            /** @var \nazares\decoracore\Controller $controller */
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $middlewares = $controller->getMiddlewares();
            foreach ($middlewares as $middleware) {
                $middleware->execute();
            }
            $callback[0] = $controller;
        }
        return call_user_func($callback, $this->request, $this->response);
    }
}
