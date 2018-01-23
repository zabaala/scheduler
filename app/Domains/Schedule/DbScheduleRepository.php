<?php

namespace App\Domains\Schedule;

use App\Domains\Schedule\Contracts\ScheduleRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DbScheduleRepository implements ScheduleRepositoryInterface
{
    /**
     * @var Schedule
     */
    private $model;

    /**
     * @var int
     */
    private $perPage = 25;

    /**
     * @param Schedule $model
     */
    public function __construct(Schedule $model)
    {
        $this->model = $model;
    }

    /**
     * Get all schedules.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return $this
            ->model
            ->newQuery()
            ->select([
                'schedules.doctor_id',
                'doctors.name as doctor_name',
                'doctors.crm as doctor_crm',
                'schedules.patient_id',
                'patients.name as patient_name',
                'schedules.id',
                'schedules.status',
                'schedules.date',
                'schedules.message',
            ])
            ->whereRaw('(schedules.deleted_at is null or schedules.deleted_at = "")')
            ->leftJoin('doctors', 'doctors.id', '=', 'schedules.doctor_id')
            ->leftJoin('patients', 'patients.id', '=', 'schedules.patient_id')
            ->paginate($this->perPage);
    }

    /**
     * Create a new schedule.
     *
     * @param $status
     * @param $doctor_id
     * @param $patient_id
     * @param $date
     * @param $message
     * @return bool|Schedule
     */
    public function createNewSchedule($status, $doctor_id, $patient_id, $date, $message)
    {
        /** @var  Schedule $schedule */
        $schedule = $this->model;

        $schedule->status = $status;
        $schedule->doctor_id = $doctor_id;
        $schedule->patient_id = $patient_id;
        $schedule->date = $date;
        $schedule->message = $message;

        if (!$schedule->save()) {
            return false;
        }

        return $schedule;
    }

    /**
     * Find a schedule by id.
     *
     * @param $id
     * @return mixed
     */
    public function findScheduleById($id)
    {
        $schedule = $this
            ->model
            ->newInstance()
            ->newQuery()
            ->select([
                'schedules.doctor_id',
                'doctors.name as doctor_name',
                'doctors.crm as doctor_crm',
                'schedules.patient_id',
                'patients.name as patient_name',
                'schedules.id',
                'schedules.status',
                'schedules.date',
                'schedules.message',
            ])
            ->whereRaw('(schedules.deleted_at is null or schedules.deleted_at = "")')
            ->leftJoin('doctors', 'doctors.id', '=', 'schedules.doctor_id')
            ->leftJoin('patients', 'patients.id', '=', 'schedules.patient_id')
            ->where('schedules.id', $id)
            ->first();

        if (! $schedule) {
            throw new ModelNotFoundException("Schedule with id: ${id} not found.");
        }

        return $schedule;
    }

    /**
     * Update a schedule by id.
     *
     * @param $id
     * @param $status
     * @param $doctor_id
     * @param $patient_id
     * @param $date
     * @param $message
     * @return mixed
     */
    public function updateScheduleById($id, $status, $doctor_id, $patient_id, $date, $message)
    {
        $schedule = $this->findScheduleById($id);

        $schedule->status = $status;
        $schedule->doctor_id = $doctor_id;
        $schedule->patient_id = $patient_id;
        $schedule->date = $date;
        $schedule->message = $message;

        if (!$schedule->save()) {
            return false;
        }

        return $schedule;
    }

    /**
     * Delete a Schedule by id.
     *
     * @param $id
     * @return bool
     */
    public function deleteScheduleById($id)
    {
        if ($model = $this->findScheduleById($id)) {
            return $model->delete();
        }

        return false;
    }
}
