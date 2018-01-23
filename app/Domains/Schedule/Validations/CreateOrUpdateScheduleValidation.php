<?php

namespace App\Domains\Schedule\Validations;

use App\Domains\Schedule\Schedule;
use App\Support\Validation\Validation;
use Illuminate\Validation\Rule;

class CreateOrUpdateScheduleValidation extends Validation
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
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'status' => [
                'required',
                Rule::in(array_flatten(Schedule::$arrStatus))
            ],
            'doctor_id' => [
                'required',
                Rule::exists('doctors', 'id')
            ],
            'patient_id' => [
                'required',
                Rule::exists('patients', 'id')
            ],
            'date' => 'required|date_format:d/m/Y',
            'hour' => 'required|date_format:H:i',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [];
    }
}
