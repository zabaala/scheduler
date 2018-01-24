<?php

namespace App\Applications\Backend\Http\Controllers;

use App\Core\Http\Controllers\Controller;
use App\Domains\Doctor\DbDoctorRepository;
use App\Domains\Doctor\Doctor;
use App\Domains\Patient\DbPatientRepository;
use App\Domains\Patient\Patient;
use App\Domains\Schedule\Commands\CreateNewScheduleCommand;
use App\Domains\Schedule\Commands\UpdateScheduleByIdCommand;
use App\Domains\Schedule\DbScheduleRepository;
use App\Domains\Schedule\Schedule;
use App\Support\Command\CommandException;
use Illuminate\Http\Request;

class SchedulesController extends Controller
{
    /**
     * SchedulesController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    private function doctors()
    {
        return (new DbDoctorRepository(new Doctor()))->getAllPluckedUp();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    private function patients()
    {
        return (new DbPatientRepository(new Patient()))->getAllPluckedUp();
    }

    /**
     * @return array
     */
    private function availableStatus()
    {
        return Schedule::$arrStatusForHumans;
    }

    /**
     * Show all schedules.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $schedules = (new DbScheduleRepository(new Schedule()))->getAll('id', 'desc');
        $total = $schedules->total();

        return view('backend::schedules.index', compact('schedules', 'total')
        );
    }

    /**
     * Show schedule create form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $schedule = null;
        $action = 'create';
        $patients = $this->patients();
        $doctors = $this->doctors();
        $availableStatus = $this->availableStatus();

        return view(
            'backend::schedules.form',
            compact('schedule', 'action', 'patients', 'doctors', 'availableStatus')
        );
    }

    /**
     * Store a new schedule.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $command = new CreateNewScheduleCommand($request->all());
            $command->handle();
        } catch (CommandException $commandException) {
            return redirect()->back()->with('errors', $commandException->getError())->withInput();
        }

        return redirect()->route('backend.schedules.index')->with('success', 'Schedule created with success.');
    }

    /**
     * Edit a schedule.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $action = 'edit';
        $schedule = (new DbScheduleRepository(new Schedule()))->findScheduleById($id);

        $patients = $this->patients();
        $doctors = $this->doctors();
        $availableStatus = $this->availableStatus();

        return view(
            'backend::schedules.form',
            compact('schedule', 'action', 'patients', 'doctors', 'availableStatus')
        );
    }

    /**
     * Store a new schedule.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $command = new UpdateScheduleByIdCommand($id, $request->all());
            $command->handle();
        } catch (CommandException $commandException) {
            return redirect()->back()->with('errors', $commandException->getError())->withInput();
        }

        return redirect()->route('backend.schedules.index')->with('success', 'Schedule updated with success.');
    }

    /**
     * Destroy a schedule.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        (new DbScheduleRepository(new Schedule()))->deleteScheduleById($id);
        return redirect()->route('backend.schedules.index')->with('success', 'Schedule deleted with success.');
    }
}
