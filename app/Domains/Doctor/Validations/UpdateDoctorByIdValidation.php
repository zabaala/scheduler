<?php

namespace App\Domains\Doctor\Validations;

use App\Support\Validation\Validation;

class UpdateDoctorByIdValidation extends Validation
{
    /**
     * @var $data
     */
    protected $data;

    /**
     * CreateNewDoctorValidation constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function rules() {
        return [
            'name' => 'required',
            'email' => 'required|unique:doctors,email,'.$this->data['id'].'|email',
            'cpf' => 'required|unique:doctors,cpf,'.$this->data['id'].'|cpf',
            'crm' => 'required|min:3'
        ];
    }

    /**
     * @return array
     */
    public function messages() {
        return [
            'cpf.cpf' => 'CPF is invalid.'
        ];
    }
}
