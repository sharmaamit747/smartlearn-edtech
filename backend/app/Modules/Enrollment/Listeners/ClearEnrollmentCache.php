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
        Cache::tags(['admin_enrollments'])->flush();
    }

    public function failed(Throwable $exception): void
    {
        logger()->error('Enrollment cache clear failed', [
            'exception' => $exception->getMessage(),
        ]);
    }
}
