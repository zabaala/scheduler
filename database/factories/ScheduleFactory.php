<?php

use App\Domains\Doctor\Doctor;
use App\Domains\Patient\Patient;
use App\Domains\Schedule\Schedule;
use Carbon\Carbon;
use Faker\Generator as Faker;
use JansenFelipe\FakerBR\FakerBR;

$factory->define(Schedule::class, function (Faker $faker) {

    $faker->addProvider(new FakerBR($faker));

    return [
        'status' => array_rand(Schedule::$arrStatusForHumans),
        'doctor_id' => function () {
            return factory(Doctor::class)->create()->id;
        },
        'patient_id' => function () {
            return factory(Patient::class)->create()->id;
        },
        'date' => Carbon::now()->toDateTimeString(),
        'message' => $faker->text(124),
    ];
});

$factory->state(Schedule::class, 'pending', function () {
    return [
        'status' => Schedule::STATUS_PENDING
    ];
});

$factory->state(Schedule::class, 'completed', function () {
    return [
        'status' => Schedule::STATUS_COMPLETED
    ];
});

$factory->state(Schedule::class, 'canceled', function () {
    return [
        'status' => Schedule::STATUS_CANCELED
    ];
});