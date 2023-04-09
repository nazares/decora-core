<?php

namespace nazares\decora-core\form;

/**
 * Class TextareaField
 *
 * @author Sergei Nazarenko <nazares@icloud.com>
 * @package nazares\decora-core\form
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
