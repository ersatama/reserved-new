<?php

namespace App\Providers;

use App\Events\ReviewCreated;
use App\Listeners\OrganizationReview;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\OrganizationProcessed;
use App\Listeners\OrganizationTables;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrganizationProcessed::class => [
            OrganizationTables::class
        ],
        ReviewCreated::class => [
            OrganizationReview::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
