<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Infrastructure\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

final class MyJob
{
    public static function launchSimple(string $errorPrefix, string $logChannel, callable $callback): void
    {
        try {
            $callback();
        } catch (Throwable $exception) {
            Log::channel($logChannel)->error($errorPrefix.$exception->getMessage());
        }
    }

    public static function launchWithDb(string $errorPrefix, string $logChannel, callable $callback): void
    {
        DB::beginTransaction();
        try {
            $callback();
            DB::commit();
        } catch (Throwable $exception) {
            DB::rollback();
            Log::channel($logChannel)->error($errorPrefix.$exception->getMessage());
        }
    }
}
