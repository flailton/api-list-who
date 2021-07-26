<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Phone;

class PhoneServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when('App\Repositories\PhoneRepository')
            ->needs('App\Models\Phone')
            ->give(function () {
                return new Phone();
            });

        $this->app->when('App\Services\PhoneService')
            ->needs('App\Interfaces\IPhoneRepository')
            ->give('App\Repositories\PhoneRepository');

        $this->app->when('App\Http\Controllers\Api\ContactController')
            ->needs('App\Interfaces\IPhoneService')
            ->give('App\Services\PhoneService');
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
