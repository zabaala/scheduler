<?php

namespace App\Applications\Api\V1\Http\Controllers;

use App\Core\Http\Controllers\Controller;
use App\Domains\Doctor\DbDoctorRepository;
use App\Domains\Doctor\Doctor;

class DoctorsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return (new DbDoctorRepository(new Doctor()))->getAll('name', 'asc');
    }
}
