<?php

namespace App\Domains\Doctor\Validations;

use App\Support\Validation\Validation;
use Illuminate\Validation\Rule;

class CreateNewDoctorValidation extends Validation
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
            'email' => [
                'required',
                Rule::unique('doctors', 'email')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
                'email'
            ],
            'cpf' => [
                'required',
                Rule::unique('doctors', 'cpf')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
                'cpf'
            ],
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
