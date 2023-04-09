<?php

namespace nazares\decora-core\exception;

/**
 * Class ForbiddenException
 *
 * @author Sergei Nazarenko <nazares@icloud.com>
 * @package nazares\decora-core\exception
 */
class ForbiddenException extends \Exception
{
    protected $message = 'You don\'t have permisson to access this page';
    protected $code = 403;
}
