<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Helpers;

use Illuminate\Support\Facades\Log;

final class MyLog
{
    public static function error(string $message): void
    {
        Log::error($message);
    }

    public static function onQueuesError(string $message): void
    {
        Log::channel('queues')->error($message);
    }
}
