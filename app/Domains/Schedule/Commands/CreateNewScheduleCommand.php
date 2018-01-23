<?php

namespace App\Domains\Schedule\Commands;

use App\Domains\Schedule\DbScheduleRepository;
use App\Domains\Schedule\Schedule;
use App\Domains\Schedule\Validations\CreateOrUpdateScheduleValidation;
use App\Support\Command\Command;
use Carbon\Carbon;

class CreateNewScheduleCommand extends Command
{
    /**
     * @var array
     */
    protected $data;

    /**
     * CreateNewScheduleCommand constructor.
     *
     * @param $data
     */
    public function __construct($data)
    {
        parent::__construct($data);
        $this->data = collect($data);
    }

    /**
     * Handle the command.
     *
     * @return mixed
     */
    public function handle()
    {
        $date = sprintf(
            '%s %s',
            Carbon::createFromFormat('d/m/Y', $this->data->get('date'))->format('Y-m-d'),
            $this->data->get('hour') . ':00'
        );

        return (new DbScheduleRepository(new Schedule()))->createNewSchedule(
            $this->data->get('status'),
            $this->data->get('doctor_id'),
            $this->data->get('patient_id'),
            $date,
            $this->data->get('message')
        );
    }

    /**
     * Define validation class.
     *
     * @return string
     */
    public function validation()
    {
        return CreateOrUpdateScheduleValidation::class;
    }
}
