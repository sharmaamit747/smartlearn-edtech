<?php

namespace App\Modules\Enrollment\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\InteractsWithQueue;
use Throwable;

class ClearEnrollmentCache implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(): void
    {
        Cache::increment('admin_enrollments_version');
    }

    public function failed(\Throwable $exception): void
    {
        logger()->error('Cache version increment failed', [
            'error' => $exception->getMessage(),
        ]);
    }
}
