<?php

namespace nazares\decoracore;

/**
 * Class Response
 *
 * @author Sergei Nazarenko <nazares@icloud.com>
 * @package nazares\decoracore
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
