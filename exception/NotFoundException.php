<?php

namespace nazares\decora-core\exception;

class NotFoundException extends \Exception
{
    protected $message = 'Page Not Found';
    protected $code = 404;
}
