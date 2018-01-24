<?php

namespace App\Applications\Backend\Http\Controllers;

use App\Core\Http\Controllers\Controller;
use App\Domains\Doctor\Contracts\DoctorRepositoryInterface;
use App\Domains\Doctor\DbDoctorRepository;
use App\Domains\Doctor\Doctor;
use App\Domains\Patient\Contracts\PatientRepositoryInterface;
use App\Domains\Patient\DbPatientRepository;
use App\Domains\Patient\Patient;
use App\Domains\Schedule\Commands\CreateNewScheduleCommand;
use App\Domains\Schedule\Commands\UpdateScheduleByIdCommand;
use App\Domains\Schedule\Contracts\ScheduleRepositoryInterface;
use App\Domains\Schedule\DbScheduleRepository;
use App\Domains\Schedule\Schedule;
use App\Support\Command\CommandException;
use Illuminate\Http\Request;

class SchedulesController extends Controller
{
    /**
     * @var PatientRepositoryInterface
     */
    private $patientRepository;
    /**
     * @var DoctorRepositoryInterface
     */
    private $doctorRepository;

    /**
     * SchedulesController constructor.
     * @param PatientRepositoryInterface $patientRepository
     * @param DoctorRepositoryInterface $doctorRepository
     */
    public function __construct(
        PatientRepositoryInterface $patientRepository,
        DoctorRepositoryInterface $doctorRepository)
    {
        $this->middleware(['auth']);
        $this->patientRepository = $patientRepository;
        $this->doctorRepository = $doctorRepository;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    private function doctors()
    {
        return $this->doctorRepository->getAllPluckedUp();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    private function patients()
    {
        return $this->patientRepository->getAllPluckedUp();
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
     * @param ScheduleRepositoryInterface $scheduleRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ScheduleRepositoryInterface $scheduleRepository)
    {
        $schedules = $scheduleRepository->getAll('schedules.id', 'desc');
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
     * @param ScheduleRepositoryInterface $scheduleRepository
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(ScheduleRepositoryInterface $scheduleRepository, $id)
    {
        $action = 'edit';
        $schedule = $scheduleRepository->findScheduleById($id);

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
     * @param ScheduleRepositoryInterface $scheduleRepository
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ScheduleRepositoryInterface $scheduleRepository, $id)
    {
        $scheduleRepository->deleteScheduleById($id);
        return redirect()->route('backend.schedules.index')->with('success', 'Schedule deleted with success.');
    }
}
