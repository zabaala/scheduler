<?php

use App\Support\CRMGenerator;
use Faker\Factory as Faker;
use JansenFelipe\FakerBR\FakerBR;

$factory->define(\App\Domains\Doctor\Doctor::class, function (Faker $faker) {

    $this->faker = Faker::create();
    $this->faker->addProvider(new FakerBR($this->faker));

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->email,
        'cpf' => $faker->cpf,
        'crm' => CRMGenerator::generate(),
        'specialty' => $faker->sentence(1, false),
    ];
});