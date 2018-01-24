<?php

namespace App\Applications\Api\V1\Http\Controllers;

use App\Core\Http\Controllers\Controller;
use App\Domains\Schedule\Contracts\ScheduleRepositoryInterface;

class SchedulesController extends Controller
{
    /**
     * @param ScheduleRepositoryInterface $scheduleRepository
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(ScheduleRepositoryInterface $scheduleRepository)
    {
        return $scheduleRepository->getAll('schedules.id', 'asc');
    }
}
