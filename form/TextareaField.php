<?php

namespace app\core\form;

/**
 * Class TextareaField
 *
 * @author Sergei Nazarenko <nazares@icloud.com>
 * @package app\core\form
 */
class TextareaField extends BaseField
{
    public function renderInput(): string
    {
        return sprintf(
            '<textarea name="%s" class="form-control%s">%s</textarea>',
            $this->attribute,
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->model->{$this->attribute}
        );
    }
}
