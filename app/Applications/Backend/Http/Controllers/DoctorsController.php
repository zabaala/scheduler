<?php

namespace App\Applications\Backend\Http\Controllers;

use App\Core\Http\Controllers\Controller;
use App\Domains\Doctor\DbDoctorRepository;
use App\Domains\Doctor\Doctor;

class DoctorsController extends Controller
{
    /**
     * DoctorsController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Show all doctors.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $doctors = (new DbDoctorRepository(new Doctor()))->getAll();
        $total = $doctors->total();

        return view('backend::doctors.index', compact('doctors', 'total'));
    }

    /**
     * Show doctor create form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $doctor = null;
        $action = 'create';
        return view('backend::doctors.form', compact('doctor', 'action'));
    }
}
