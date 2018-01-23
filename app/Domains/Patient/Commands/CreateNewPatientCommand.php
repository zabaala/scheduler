<?php

namespace App\Domains\Patient\Command;

use App\Domains\Doctor\Validations\CreateNewPatientValidation;
use App\Domains\Patient\DbPatientRepository;
use App\Domains\Patient\Patient;
use App\Support\Command\CommandException;
use App\Support\Cpf;

class CreateNewPatientCommand extends CommandException
{
    /**
     * @var array
     */
    protected $data;

    /**
     * CreateNewDoctorCommand constructor.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $data['cpf'] = (new Cpf($data['cpf']))->clean();

        parent::__construct($data);
        $this->data = collect($data);
    }

    /**
     * Handle command.
     *
     * @return mixed
     */
    public function handle()
    {
        $doctor = new DbPatientRepository(new Patient());

        return $doctor->createNewPatient(
            $this->data->get('name'),
            $this->data->get('email'),
            $this->data->get('cpf')
        );
    }

    /**
     * Define validation to this command.
     *
     * @return string
     */
    protected function validation()
    {
        return CreateNewPatientValidation::class;
    }
}
