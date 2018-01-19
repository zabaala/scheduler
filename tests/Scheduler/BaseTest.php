<?php

namespace Tests\Scheduler;

use Illuminate\Foundation\Testing\RefreshDatabase;
use JansenFelipe\FakerBR\FakerBR;
use Tests\TestCase;
use Faker\Factory as Faker;

abstract class BaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \Faker\Generator
     */
    protected $faker;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrator');

        $this->faker = Faker::create();
        $this->faker->addProvider(new FakerBR($this->faker));
    }
}
