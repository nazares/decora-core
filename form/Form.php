<?php

namespace nazares\decoracore\form;

use nazares\decoracore\Model;

/**
 * Class Form
 *
 * @author Sergei Nazarenko <nazares@icloud.com>
 * @package nazares\decoracore\form
 */
class Form
{
    public static function begin(string $action, string $method): Form
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();
    }

    public static function end(): void
    {
        echo '</form>';
    }

    public function field(Model $model, string $attribute): InputField
    {
        return new InputField($model, $attribute);
    }
}
