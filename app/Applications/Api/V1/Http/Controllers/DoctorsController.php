<?php

namespace App\Applications\Api\V1\Http\Controllers;

use App\Core\Http\Controllers\Controller;
use App\Domains\Doctor\Contracts\DoctorRepositoryInterface;

class DoctorsController extends Controller
{
    /**
     * @param DoctorRepositoryInterface $doctorRepository
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(DoctorRepositoryInterface $doctorRepository)
    {
        return $doctorRepository->getAll('name', 'asc');
    }
}
