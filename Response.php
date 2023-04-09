<?php

namespace nazares\decora-core;

/**
 * Class Response
 *
 * @author Sergei Nazarenko <nazares@icloud.com>
 * @package nazares\decora-core
 */
class Response
{
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect(string $url)
    {
        header('Location: ' . $url);
    }
}
