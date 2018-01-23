<?php

namespace App\Domains\Patient\Commands;

use App\Domains\Patient\DbPatientRepository;
use App\Domains\Patient\Patient;
use App\Domains\Patient\Validations\UpdatePatientByIdValidation;
use App\Support\Command\Command;
use App\Support\Cpf;

class UpdatePatientByIdCommand extends Command
{
    /**
     * @var array
     */
    protected $data;

    /**
     * CreateNewPatientCommand constructor.
     *
     * @param $id
     * @param $data
     */
    public function __construct($id, $data)
    {
        $data['id'] = $id;
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

        return $doctor->updatePatientById(
            $this->data->get('id'),
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
        return UpdatePatientByIdValidation::class;
    }


}
