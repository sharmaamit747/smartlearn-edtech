<?php

namespace App\Modules\Enrollment\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\InteractsWithQueue;
use App\Support\ObservabilityLogger;
use Throwable;

class ClearEnrollmentCache implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(): void
    {
        $newVersion = Cache::increment('admin_enrollments_version');

        ObservabilityLogger::cache('version_incremented', [
            'new_version' => $newVersion,
        ]);
    }

    public function failed(\Throwable $exception): void
    {
        logger()->error('Cache version increment failed', [
            'error' => $exception->getMessage(),
        ]);
    }
}
