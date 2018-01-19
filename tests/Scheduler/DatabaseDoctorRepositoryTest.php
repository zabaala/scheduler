<?php

namespace Tests\Scheduler;

use App\Domains\Doctor\DbDoctorRepository;
use App\Domains\Doctor\Doctor;
use App\Support\CRMGenerator;


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
}
