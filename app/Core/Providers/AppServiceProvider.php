<?php

namespace App\Core\Providers;

use App\Domains\Doctor\Contracts\DoctorRepositoryInterface;
use App\Domains\Doctor\DbDoctorRepository;
use App\Domains\Doctor\Doctor;
use App\Domains\Patient\Contracts\PatientRepositoryInterface;
use App\Domains\Patient\DbPatientRepository;
use App\Domains\Patient\Patient;
use App\Domains\Schedule\Contracts\ScheduleRepositoryInterface;
use App\Domains\Schedule\DbScheduleRepository;
use App\Domains\Schedule\Schedule;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(DoctorRepositoryInterface::class, function () {
            return new DbDoctorRepository(new Doctor());
        });

        $this->app->bind(PatientRepositoryInterface::class, function () {
            return new DbPatientRepository(new Patient());
        });

        $this->app->bind(ScheduleRepositoryInterface::class, function () {
            return new DbScheduleRepository(new Schedule());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
