<?php

use Faker\Generator as Faker;
use JansenFelipe\FakerBR\FakerBR;

$factory->define(\App\Domains\Patient\Patient::class, function (Faker $faker) {

    $faker->addProvider(new FakerBR($faker));

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->email,
        'cpf' => $faker->cpf
    ];
});