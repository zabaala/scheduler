<?php

use App\Support\CRMGenerator;
use Faker\Generator as Faker;
use JansenFelipe\FakerBR\FakerBR;

$factory->define(\App\Domains\Doctor\Doctor::class, function (Faker $faker) {

    $faker->addProvider(new FakerBR($faker));

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->email,
        'cpf' => $faker->cpf,
        'crm' => CRMGenerator::generate(),
        'specialty' => $faker->sentence(1, false),
    ];
});