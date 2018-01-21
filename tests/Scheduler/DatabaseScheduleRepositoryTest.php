<?php

namespace Tests\Scheduler;

use App\Domains\Doctor\Doctor;
use App\Domains\Patient\Patient;
use App\Domains\Schedule\DbScheduleRepository;
use App\Domains\Schedule\Schedule;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;


class DatabaseScheduleRepositoryTest extends BaseTest
{
    /**
     * @var DbScheduleRepository
     */
    private $repository;

    /**
     * Setting up test.
     */
    public function setUp()
    {
        parent::setUp();
        $this->repository  = new DbScheduleRepository(new Schedule());
    }

    public function test_get_all_schedules()
    {
        factory(Schedule::class, 20)->create();

        $schedules = $this->repository->getAll();

        $this->assertInstanceOf(LengthAwarePaginator::class, $schedules);

        $this->assertEquals(20, $schedules->total());

    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_create_a_new_schedule()
    {
        $status = Schedule::STATUS_PENDING;
        $doctor_id = factory(Doctor::class)->create()->id;
        $patient_id = factory(Patient::class)->create()->id;
        $date = now()->toDateTimeString();
        $message = $this->faker->text(200);

        $schedule = $this->repository->createNewSchedule($status, $doctor_id, $patient_id, $date, $message);

        $this->assertInstanceOf(Schedule::class, $schedule);

        $this->assertEquals($doctor_id, $schedule->doctor_id);
        $this->assertEquals($patient_id, $schedule->patient_id);
        $this->assertEquals($date, $schedule->date);
        $this->assertEquals($message, $schedule->message);

        $this->assertInstanceOf(Carbon::class, $schedule->date);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function test_find_by_id_a_non_existent_schedule()
    {
        $this->repository->findScheduleById(999);
    }

    public function test_find_schedule_by_id()
    {
        $factory = factory(Schedule::class)->create();

        $schedule = $this->repository->findScheduleById($factory->id);

        $this->assertEquals($factory->id, $schedule->id);
        $this->assertEquals($factory->doctor->name, $schedule->doctor_name);
        $this->assertEquals($factory->patient->name, $schedule->patient_name);
    }

    public function test_update_a_schedule()
    {
        $factory = factory(Schedule::class)->states('completed')->create();

        $status = Schedule::STATUS_PENDING;
        $doctor_id = factory(Doctor::class)->create()->id;
        $patient_id = factory(Patient::class)->create()->id;
        $date = now()->toDateTimeString();
        $message = $this->faker->text(200);

        $schedule = $this->repository->updateScheduleById($factory->id, $status, $doctor_id, $patient_id, $date, $message);

        $this->assertInstanceOf(Schedule::class, $schedule);

        $this->assertEquals($doctor_id, $schedule->doctor_id);
        $this->assertEquals($patient_id, $schedule->patient_id);
        $this->assertEquals($date, $schedule->date);
        $this->assertEquals($message, $schedule->message);

        $this->assertInstanceOf(Carbon::class, $schedule->date);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function test_delete_a_non_existent_schedule()
    {
        $this->repository->deleteScheduleById(957);
    }

    public function test_delete_a_existent_schedule()
    {
        Schedule::query()->truncate();

        $schedules = factory(Schedule::class, 1)->create();

        $result = $this->repository->deleteScheduleById($schedules->get(0)->id);

        $this->assertTrue($result);
        $this->assertEquals(0, $this->repository->getAll()->total());
    }
}
