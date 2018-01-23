<?php

namespace App\Applications\Api\V1\Http\Controllers;

use App\Core\Http\Controllers\Controller;
use App\Domains\Patient\DbPatientRepository;
use App\Domains\Patient\Patient;

class PatientsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return (new DbPatientRepository(new Patient()))->getAll();
    }
}
