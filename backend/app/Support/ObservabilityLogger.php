<?php

namespace App\Support;

use Illuminate\Support\Facades\Log;

class ObservabilityLogger
{
    public static function enrollment(string $action, array $context = []): void
    {
        Log::channel('daily')->info("enrollment.{$action}", $context);
    }

    public static function cache(string $action, array $context = []): void
    {
        Log::channel('daily')->info("cache.{$action}", $context);
    }

    public static function queue(string $action, array $context = []): void
    {
        Log::channel('daily')->warning("queue.{$action}", $context);
    }
}
