<?php

namespace App\Modules\Enrollment\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;

class ClearEnrollmentCache implements ShouldQueue
{
    public string $queue = 'enrollments';

    public function handle(): void
    {
        Cache::tags(['admin_enrollments'])->flush();
    }
}
