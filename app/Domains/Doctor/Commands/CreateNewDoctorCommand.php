<?php

namespace App\Domains\Doctor\Commands;

use App\Domains\Doctor\DbDoctorRepository;
use App\Domains\Doctor\Doctor;
use App\Domains\Doctor\Validations\CreateNewDoctorValidation;
use App\Support\Command\Command;

class CreateNewDoctorCommand extends Command
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
        $doctor = new DbDoctorRepository(new Doctor());

        return $doctor->createNewDoctor(
            $this->data->get('name'),
            $this->data->get('email'),
            $this->data->get('cpf'),
            $this->data->get('crm'),
            $this->data->get('specialty')
        );
    }

    /**
     * Define validation to this command.
     *
     * @return string
     */
    protected function validation()
    {
        return CreateNewDoctorValidation::class;
    }
}
