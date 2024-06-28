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

    public static function errorOnQueues(string $message): void
    {
        Log::channel('queues')->error($message);
    }

    public static function errorOnLoads(string $message): void
    {
        Log::channel('queues')->error($message);
    }

    public static function errorOn(string $channel, string $message): void
    {
        Log::channel($channel)->error($message);
    }
}
