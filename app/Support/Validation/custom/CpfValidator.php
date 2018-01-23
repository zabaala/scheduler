<?php

namespace App\Support\Validation\Custom;

use App\Support\Cpf;
use Illuminate\Validation\Validator;

class CpfValidator
{
    /**
     * @param $attribute
     * @param $value
     * @param $params
     * @param Validator $validator
     * @return bool
     */
    public function validate($attribute, $value, $params, Validator $validator)
    {
        return (new Cpf($value))->validate();
    }
}