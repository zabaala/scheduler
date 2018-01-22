<?php

namespace App\Applications\Backend\Http\Controllers;

use App\Core\Http\Controllers\Controller;
use App\Domains\Doctor\Commands\CreateNewDoctorCommand;
use App\Domains\Doctor\DbDoctorRepository;
use App\Domains\Doctor\Doctor;
use App\Support\Command\CommandException;
use Illuminate\Http\Request;

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

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $command = new CreateNewDoctorCommand($request->all());
            $command->handle();
        } catch (CommandException $commandException) {
            return redirect()->back()->with('errors', $commandException->getError())->withInput();
        }

        return redirect()->route('backend.doctors.index')->with('success', 'Doctor created with success.');
    }
}
