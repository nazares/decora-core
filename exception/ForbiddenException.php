<?php

namespace app\core\exception;

/**
 * Class ForbiddenException
 *
 * @author Sergei Nazarenko <nazares@icloud.com>
 * @package app\core\exception
 */
class ForbiddenException extends \Exception
{
    protected $message = 'You don\'t have permisson to access this page';
    protected $code = 403;
}
