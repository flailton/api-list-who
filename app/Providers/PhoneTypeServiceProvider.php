<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\PhoneType;

class PhoneTypeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when('App\Repositories\PhoneTypeRepository')
            ->needs('App\Models\PhoneType')
            ->give(function () {
                $route = request()->route();

                if ($route && $route->hasParameter('phonetype')) {
                    if ($phonetype = PhoneType::find($route->parameter('phonetype'))) {
                        return $phonetype;
                    }
                }

                return new PhoneType();
            });

        $this->app->when('App\Services\PhoneTypeService')
            ->needs('App\Interfaces\IPhoneTypeRepository')
            ->give('App\Repositories\PhoneTypeRepository');

        $this->app->when('App\Http\Controllers\Api\PhoneTypeController')
            ->needs('App\Interfaces\IPhoneTypeService')
            ->give('App\Services\PhoneTypeService');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
