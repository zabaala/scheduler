<?php

namespace Tests\Scheduler;

use App\Domains\Doctor\DbDoctorRepository;
use App\Domains\Doctor\Doctor;
use App\Support\CRMGenerator;
use Illuminate\Pagination\LengthAwarePaginator;


class DatabaseDoctorRepositoryTest extends BaseTest
{
    /**
     * @var DbDoctorRepository
     */
    private $repository;

    /**
     * Setting up test.
     */
    public function setUp()
    {
        parent::setUp();
        $this->repository  = new DbDoctorRepository(new Doctor());
    }

    public function test_get_all_doctors()
    {
        factory(Doctor::class, 20)->create();

        $doctors = $this->repository->getAll();

        $this->assertInstanceOf(LengthAwarePaginator::class, $doctors);

        $this->assertEquals(20, $doctors->total());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_create_a_new_doctor()
    {
        $name = $this->faker->name;
        $email = $this->faker->unique()->email;
        $cpf = $this->faker->cpf;
        $crm = CRMGenerator::generate();
        $specialty = $this->faker->sentence(1, false);

        $doctor = $this->repository->createNewDoctor($name, $email, $cpf, $crm, $specialty);

        $this->assertInstanceOf(Doctor::class, $doctor);

        $this->assertEquals($name, $doctor->name);
        $this->assertEquals($email, $doctor->email);
        $this->assertEquals($cpf, $doctor->cpf);
        $this->assertEquals($crm, $doctor->crm);
        $this->assertEquals($specialty, $doctor->specialty);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function test_find_by_id_a_non_existent_doctor()
    {
        $this->repository->findDoctorById(999);
    }

    public function test_find_doctor_by_id()
    {
        $doctors = factory(Doctor::class, 3)->create();

        $factoryDoctor = $doctors[2];

        $doctor = $this->repository->findDoctorById($factoryDoctor->id);

        $this->assertEquals($factoryDoctor->name, $doctor->name);
    }

    public function test_update_a_doctor()
    {
        $name = $this->faker->name;
        $email = $this->faker->unique()->email;
        $cpf = $this->faker->cpf;
        $crm = CRMGenerator::generate();
        $specialty = $this->faker->sentence(1, false);

        $doctor = $this->repository->createNewDoctor($name, $email, $cpf, $crm, $specialty);

        $newName = $this->faker->name;
        $newEmail = $this->faker->unique()->email;
        $newCpf = $this->faker->cpf;
        $newCrm = CRMGenerator::generate();
        $newSpecialty = $this->faker->sentence(1, false);

        $updatedDoctor = $this->repository->updateDoctorById($doctor->id, $newName, $newEmail, $newCpf, $newCrm, $newSpecialty);

        $this->assertInstanceOf(Doctor::class, $updatedDoctor);

        $this->assertEquals($newName, $updatedDoctor->name);
        $this->assertEquals($newEmail, $updatedDoctor->email);
        $this->assertEquals($newCpf, $updatedDoctor->cpf);
        $this->assertEquals($newCrm, $updatedDoctor->crm);
        $this->assertEquals($newSpecialty, $updatedDoctor->specialty);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function test_delete_a_non_existent_doctor()
    {
        $this->repository->deleteDoctorById(957);
    }

    public function test_delete_a_existent_doctor()
    {
        Doctor::query()->truncate();

        $patients = factory(Doctor::class, 1)->create();

        $result = $this->repository->deleteDoctorById($patients->get(0)->id);

        $this->assertTrue($result);
        $this->assertEquals(0, $this->repository->getAll()->total());
    }
}
