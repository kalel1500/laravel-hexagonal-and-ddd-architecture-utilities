<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

final class MyJob
{
    public static function launchSimple(string $errorPrefix, callable $callback): void
    {
        try {
            $callback();
        } catch (Throwable $exception) {
            $errorMessage = MyCarbon::now()->format(MyCarbon::$datetime_startYear).";".$errorPrefix.$exception->getMessage();
            echo $errorMessage;
            Log::error($errorMessage);
        }
    }

    public static function launchWithDb(string $errorPrefix, callable $callback): void
    {
        DB::beginTransaction();
        try {
            $callback();
            DB::commit();
        } catch (Throwable $exception) {
            DB::rollback();
            $errorMessage = "dia: ".MyCarbon::now()->format(MyCarbon::$datetime_startYear)." || ".$errorPrefix.$exception->getMessage();
            echo $errorMessage;
            Log::error($errorMessage);
        }
    }
}
