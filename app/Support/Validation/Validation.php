<?php

namespace App\Support\Validation;

use Illuminate\Support\Facades\Validator;

abstract class Validation
{
    /**
     * @var array
     */
    protected $data;

    /**
     * Validation constructor.
     *
     * @param array $data
     */
    abstract public function __construct(array $data);

    /**
     * @return array
     */
    abstract public function rules();

    /**
     * @return array
     */
    abstract public function messages();

    /**
     * Perform validation.
     *
     * @return bool
     * @throws ValidationException
     */
    public function validate()
    {
        /** @var \Illuminate\Validation\Validator $validator */
        $validator = Validator::make($this->data, $this->rules(), $this->messages());

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

        return true;
    }
}
