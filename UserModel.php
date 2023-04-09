<?php

namespace app\core;

use app\core\db\DbModel;

/**
 * Class UserModel
 *
 * @author Sergei Nazarenko <nazares@icloud.com>
 * @package app\core
 */
abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}
