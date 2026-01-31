<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Modules\Course\Models\Course;
use App\Modules\Course\Policies\CoursePolicy;
use App\Modules\User\Models\User;
use App\Modules\User\Policies\UserPolicy;
use App\Modules\Enrollment\Models\Enrollment;
use App\Modules\Enrollment\Policies\EnrollmentPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Course::class => CoursePolicy::class,
        User::class => UserPolicy::class,
        Enrollment::class => EnrollmentPolicy::class,
    ];

    /**
     * Bootstrap any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
