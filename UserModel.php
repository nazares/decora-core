<?php

namespace nazares\decora-core;

use nazares\decora-core\db\DbModel;

/**
 * Class UserModel
 *
 * @author Sergei Nazarenko <nazares@icloud.com>
 * @package nazares\decora-core
 */
abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}
