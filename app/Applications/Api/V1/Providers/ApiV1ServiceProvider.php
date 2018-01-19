<?php

namespace App\Applications\Api\V1\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class ApiV1ServiceProvider extends ServiceProvider
{
    /**
     * Override default laravel application controller namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Applications\Api\V1\Http\Controllers';

    /**
     * Boot the service provider.
     * @param Router $route
     */
    public function boot(Router $route)
    {
        $options = [
            'namespace' => $this->namespace,
            'prefix' => 'api/v1',
            'as' => 'ap1.v1.'
        ];

        $route->group($options, function(){
            require app_path('Applications/Api/v1/Http/routes.php');
        });
    }
}
