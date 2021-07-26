<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Contact;

class ContactServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when('App\Repositories\ContactRepository')
            ->needs('App\Models\Contact')
            ->give(function () {
                $route = request()->route();

                if ($route && $route->hasParameter('contact')) {
                    if ($contact = Contact::find($route->parameter('contact'))) {
                        return $contact;
                    }
                }

                return new Contact();
            });

        $this->app->when('App\Services\ContactService')
            ->needs('App\Interfaces\IContactRepository')
            ->give('App\Repositories\ContactRepository');

        $this->app->when('App\Services\ContactService')
            ->needs('App\Interfaces\ILinkService')
            ->give('App\Services\LinkService');

        $this->app->when('App\Services\ContactService')
            ->needs('App\Interfaces\IPhoneService')
            ->give('App\Services\PhoneService');

        $this->app->when('App\Http\Controllers\Api\ContactController')
            ->needs('App\Interfaces\IContactService')
            ->give('App\Services\ContactService');
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
