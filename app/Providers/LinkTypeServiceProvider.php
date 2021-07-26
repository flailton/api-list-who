<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\LinkType;

class LinkTypeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when('App\Repositories\LinkTypeRepository')
            ->needs('App\Models\LinkType')
            ->give(function () {
                $route = request()->route();

                if ($route && $route->hasParameter('linktype')) {
                    if ($linktype = LinkType::find($route->parameter('linktype'))) {
                        return $linktype;
                    }
                }

                return new LinkType();
            });

        $this->app->when('App\Services\LinkTypeService')
            ->needs('App\Interfaces\ILinkTypeRepository')
            ->give('App\Repositories\LinkTypeRepository');

        $this->app->when('App\Http\Controllers\Api\LinkTypeController')
            ->needs('App\Interfaces\ILinkTypeService')
            ->give('App\Services\LinkTypeService');
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
