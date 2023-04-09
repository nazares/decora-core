<?php

namespace nazares\decoracore;

use nazares\decoracore\db\DbModel;

/**
 * Class UserModel
 *
 * @author Sergei Nazarenko <nazares@icloud.com>
 * @package nazares\decoracore
 */
abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}
