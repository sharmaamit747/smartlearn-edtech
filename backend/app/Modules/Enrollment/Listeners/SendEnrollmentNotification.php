<?php

namespace App\Modules\Enrollment\Listeners;

use App\Modules\Enrollment\Events\EnrollmentCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Support\ObservabilityLogger;

class SendEnrollmentNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public string $queue = 'notifications';

    public function handle(EnrollmentCreated $event): void
    {
        logger()->info('Enrollment notification queued', [
            'enrollment_id' => $event->enrollment->id,
            'user_id'       => $event->enrollment->user_id,
            'course_id'     => $event->enrollment->course_id,
        ]);
        ObservabilityLogger::queue('notification_handled', [
            'enrollment_id' => $event->enrollment->id,
        ]);
    }

    public function failed(\Throwable $exception): void
    {
        logger()->error('Enrollment notification failed', [
            'error' => $exception->getMessage(),
        ]);
        ObservabilityLogger::queue('notification_failed', [
            'error' => $exception->getMessage(),
        ]);
    }
}
