<?php

namespace App\Services\Conditionals;

class HideConditional
{

    public const CONDITIONAL_ID = 'hide';

    public const CONDITIONAL_NAME = 'Hide';

    public function form(&$formData, &$registeredFields)
    {
        return;
    }
}
