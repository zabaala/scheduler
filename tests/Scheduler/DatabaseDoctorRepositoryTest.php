<?php

namespace Tests\Scheduler;

use App\Domains\Doctor\DbDoctorRepository;
use App\Domains\Doctor\Doctor;
use App\Support\CRMGenerator;
use Faker\Factory as Faker;
use JansenFelipe\FakerBR\FakerBR;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DatabaseDoctorRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var DbDoctorRepository
     */
    private $repository;

    /**
     * @var Faker
     */
    private $faker;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrator');

        $this->repository  = new DbDoctorRepository(new Doctor());

        $this->faker = Faker::create();
        $this->faker->addProvider(new FakerBR($this->faker));
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
