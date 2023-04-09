<?php

namespace nazares\decora-core\middlewares;

use nazares\decora-core\Application;
use nazares\decora-core\exception\ForbiddenException;

/**
 * Class AuthMiddleware
 *
 * @author Sergei Nazarenko <nazares@icloud.com>
 * @package nazares\decora-core\middlewares
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
