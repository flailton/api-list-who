<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Link;

class LinkServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when('App\Repositories\LinkRepository')
            ->needs('App\Models\Link')
            ->give(function () {
                return new Link();
            });

        $this->app->when('App\Services\LinkService')
            ->needs('App\Interfaces\ILinkRepository')
            ->give('App\Repositories\LinkRepository');

        $this->app->when('App\Http\Controllers\Api\ContactController')
            ->needs('App\Interfaces\ILinkService')
            ->give('App\Services\LinkService');
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
