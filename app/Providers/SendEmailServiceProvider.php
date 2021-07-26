<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Jobs\SendEmailJob;

class SendEmailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when('App\Repositories\SendEmailService')
            ->needs('App\Jobs\SendEmailJob')
            ->give(function () {
                return new SendEmailJob();
            });
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
