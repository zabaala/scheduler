<?php

namespace App\Applications\Backend\Http\Controllers;

use App\Core\Http\Controllers\Controller;
use App\Domains\Patient\Commands\CreateNewPatientCommand;
use App\Domains\Patient\Commands\UpdatePatientByIdCommand;
use App\Domains\Patient\DbPatientRepository;
use App\Domains\Patient\Patient;
use App\Support\Command\CommandException;
use Illuminate\Http\Request;

class PatientsController extends Controller
{
    /**
     * PatientsController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Show all patients.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $patients = (new DbPatientRepository(new Patient()))->getAll('id', 'desc');
        $total = $patients->total();

        return view('backend::patients.index', compact('patients', 'total'));
    }

    /**
     * Show patient create form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $patient = null;
        $action = 'create';
        return view('backend::patients.form', compact('patient', 'action'));
    }

    /**
     * Store a new patient.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $command = new CreateNewPatientCommand($request->all());
            $command->handle();
        } catch (CommandException $commandException) {
            return redirect()->back()->with('errors', $commandException->getError())->withInput();
        }

        return redirect()->route('backend.patients.index')->with('success', 'Patient created with success.');
    }

    /**
     * Edit a patient.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $action = 'edit';
        $patient = (new DbPatientRepository(new Patient()))->findPatientById($id);

        return view('backend::patients.form', compact('action', 'patient'));
    }

    /**
     * Store a new patient.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $command = new UpdatePatientByIdCommand($id, $request->all());
            $command->handle();
        } catch (CommandException $commandException) {
            return redirect()->back()->with('errors', $commandException->getError())->withInput();
        }

        return redirect()->route('backend.patients.index')->with('success', 'Patient updated with success.');
    }

    /**
     * Destroy a patient.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        (new DbPatientRepository(new Patient()))->deletePatientById($id);
        return redirect()->route('backend.patients.index')->with('success', 'Patient deleted with success.');
    }
}
