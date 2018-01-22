<?php

namespace App\Support\Validation\Custom;

use Illuminate\Support\ServiceProvider;

class CustomValidationsServiceProvider extends ServiceProvider
{
    /**
     * boot the service provider.
     */
    public function boot()
    {
        \Validator::extend('cpf', 'App\Support\Validation\Custom\CpfValidator@validate');
    }
}