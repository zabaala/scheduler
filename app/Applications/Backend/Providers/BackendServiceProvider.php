<?php

namespace App\Applications\Backend\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    /**
     * Override default laravel application controller namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Applications\Backend\Http\Controllers';

    /**
     * Boot API routes.
     */
    public function boot()
    {
        parent::boot();

        $this->loadViewsFrom(app_path('Applications/Backend/resources/views'), 'backend');

        \Route::prefix('backend')
            ->as('backend.')
            ->namespace($this->namespace)
            ->middleware(['web'])
            ->group(base_path('app/Applications/Backend/Http/routes.php'));
    }
}
