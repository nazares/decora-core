<?php

namespace nazares\decoracore\middlewares;

use nazares\decoracore\Application;
use nazares\decoracore\exception\ForbiddenException;

/**
 * Class AuthMiddleware
 *
 * @author Sergei Nazarenko <nazares@icloud.com>
 * @package nazares\decoracore\middlewares
 */
class AuthMiddleware extends BaseMiddleware
{
    public array $actions = [];

    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }

    public function execute()
    {
        if (Application::isGuest()) {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                throw new ForbiddenException();
            }
        }
    }
}
