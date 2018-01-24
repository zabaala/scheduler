<?php

namespace App\Applications\Backend\Http\Controllers;

use App\Core\Http\Controllers\Controller;
use App\Domains\Doctor\Commands\CreateNewDoctorCommand;
use App\Domains\Doctor\Commands\UpdateDoctorByIdCommand;
use App\Domains\Doctor\Contracts\DoctorRepositoryInterface;
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
     * @param DoctorRepositoryInterface $doctorRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(DoctorRepositoryInterface $doctorRepository)
    {
        $doctors = $doctorRepository->getAll('id', 'desc');
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
     * Store a new doctor.
     *
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

    /**
     * Edit a doctor.
     *
     * @param DoctorRepositoryInterface $doctorRepository
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(DoctorRepositoryInterface $doctorRepository, $id)
    {
        $action = 'edit';
        $doctor = $doctorRepository->findDoctorById($id);

        return view('backend::doctors.form', compact('action', 'doctor'));
    }

    /**
     * Store a new doctor.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $command = new UpdateDoctorByIdCommand($id, $request->all());
            $command->handle();
        } catch (CommandException $commandException) {
            return redirect()->back()->with('errors', $commandException->getError())->withInput();
        }

        return redirect()->route('backend.doctors.index')->with('success', 'Doctor updated with success.');
    }

    /**
     * Destroy a doctor.
     *
     * @param DoctorRepositoryInterface $doctorRepository
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DoctorRepositoryInterface $doctorRepository, $id)
    {
        $doctorRepository->deleteDoctorById($id);
        return redirect()->route('backend.doctors.index')->with('success', 'Doctor deleted with success.');
    }
}
