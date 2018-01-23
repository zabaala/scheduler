<?php

namespace App\Applications\Api\V1\Http\Controllers;

use App\Core\Http\Controllers\Controller;
use App\Domains\Schedule\DbScheduleRepository;
use App\Domains\Schedule\Schedule;

class SchedulesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return (new DbScheduleRepository(new Schedule()))->getAll();
    }
}
