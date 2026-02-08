<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Modules\Enrollment\Events\EnrollmentCreated;
use App\Modules\Enrollment\Events\EnrollmentCancelled;
use App\Modules\Enrollment\Events\EnrollmentCompleted;
use App\Modules\Enrollment\Listeners\ClearEnrollmentCache;
use App\Modules\Enrollment\Listeners\SendEnrollmentNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings.
     */
    protected $listen = [
        EnrollmentCreated::class => [
            ClearEnrollmentCache::class,
            SendEnrollmentNotification::class,
        ],

        EnrollmentCancelled::class => [
            ClearEnrollmentCache::class,
        ],

        EnrollmentCompleted::class => [
            ClearEnrollmentCache::class,
        ],

    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        // No need to call registerEvents() in Laravel 12
    }
}
