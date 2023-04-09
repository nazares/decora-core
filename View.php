<?php

namespace nazares\decora-core;

/**
 * Class View
 * @author Sergei Nazarenko <nazares@icloud.com>
 * @package nazares\decora-core
 */
class View
{
    public string $title = '';

    public function renderView($view, array $params = [])
    {
        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
        include_once Application::$ROOT_DIR . "/views/$view.phtml";
    }

    public function renderContent($viewContent)
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    protected function layoutContent()
    {
        $layout = Application::$app->layout;
        if (Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/main.phtml";
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.phtml";
        return ob_get_clean();
    }
}
