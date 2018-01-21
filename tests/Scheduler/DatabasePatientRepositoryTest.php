<?php

namespace Tests\Scheduler;

use App\Domains\Patient\DbPatientRepository;
use App\Domains\Patient\Patient;
use Illuminate\Pagination\LengthAwarePaginator;


class DatabasePatientRepositoryTest extends BaseTest
{
    /**
     * @var DbPatientRepository
     */
    private $repository;

    /**
     * Setting up test.
     */
    public function setUp()
    {
        parent::setUp();
        $this->repository  = new DbPatientRepository(new Patient());
    }

    public function test_get_all_patients()
    {
        factory(Patient::class, 20)->create();

        $patients = $this->repository->getAll();

        $this->assertInstanceOf(LengthAwarePaginator::class, $patients);

        $this->assertEquals(20, $patients->total());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_create_a_new_patient()
    {
        $name = $this->faker->name;
        $email = $this->faker->unique()->email;
        $cpf = $this->faker->cpf;

        $patient = $this->repository->createNewPatient($name, $email, $cpf);

        $this->assertInstanceOf(Patient::class, $patient);

        $this->assertEquals($name, $patient->name);
        $this->assertEquals($email, $patient->email);
        $this->assertEquals($cpf, $patient->cpf);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function test_find_by_id_a_non_existent_patient()
    {
        $this->repository->findPatientById(999);
    }

    public function test_find_patient_by_id()
    {
        $patients = factory(Patient::class, 3)->create();

        $factoryPatient = $patients[2];

        $patient = $this->repository->findPatientById($factoryPatient->id);

        $this->assertEquals($factoryPatient->name, $patient->name);
    }

    public function test_update_a_patient()
    {
        $name = $this->faker->name;
        $email = $this->faker->unique()->email;
        $cpf = $this->faker->cpf;

        $patient = $this->repository->createNewPatient($name, $email, $cpf);

        $newName = $this->faker->name;
        $newEmail = $this->faker->unique()->email;
        $newCpf = $this->faker->cpf;

        $updatedPatient = $this->repository->updatePatientById($patient->id, $newName, $newEmail, $newCpf);

        $this->assertInstanceOf(Patient::class, $updatedPatient);

        $this->assertEquals($newName, $updatedPatient->name);
        $this->assertEquals($newEmail, $updatedPatient->email);
        $this->assertEquals($newCpf, $updatedPatient->cpf);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function test_delete_a_non_existent_patient()
    {
        $this->repository->deletePatientById(957);
    }

    public function test_delete_a_existent_patient()
    {
        \Schema::disableForeignKeyConstraints();
        Patient::query()->truncate();
        \Schema::enableForeignKeyConstraints();

        $patients = factory(Patient::class, 1)->create();

        $result = $this->repository->deletePatientById($patients->get(0)->id);

        $this->assertTrue($result);
        $this->assertEquals(0, $this->repository->getAll()->total());
    }
}
