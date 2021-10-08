<?php

namespace App\Http\Validators;

use Illuminate\Validation\Validator;

class SimpleValidator extends Validator
{
    public function validateEven($attirbute, $value, $parameters)
    {
        return is_numeric($value) && ($value % 2 === 0);
    }
}