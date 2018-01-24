<?php

namespace App\Applications\Api\V1\Http\Controllers;

use App\Core\Http\Controllers\Controller;
use App\Domains\Patient\Contracts\PatientRepositoryInterface;

class PatientsController extends Controller
{
    /**
     * @param PatientRepositoryInterface $patientRepository
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(PatientRepositoryInterface $patientRepository)
    {
        return $patientRepository->getAll('name', 'asc');
    }
}
