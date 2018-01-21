<?php

namespace App\Domains\Schedule;

interface ScheduleRepositoryInterface
{
    /**
     * @param Schedule $model
     */
    public function __construct(Schedule $model);

    /**
     * Get all schedules.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll();

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
    public function createNewSchedule($status, $doctor_id, $patient_id, $date, $message);

    /**
     * Find a schedule by id.
     *
     * @param $id
     * @return mixed
     */
    public function findScheduleById($id);

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
    public function updateScheduleById($id, $status, $doctor_id, $patient_id, $date, $message);

    /**
     * Delete a Schedule by id.
     *
     * @param $id
     * @return bool
     */
    public function deleteScheduleById($id);

}
