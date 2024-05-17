<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Services;

use Illuminate\Support\Facades\Artisan;
use Thehouseofel\Hexagonal\Domain\Exceptions\ServiceException;
use Throwable;

class QueueService
{
    /**
     * @throws Throwable
     */
    public static function check(string $failMessage): void
    {
        $exitCode = Artisan::call('service:check');
        $active = ($exitCode !== 0 && !str_contains(Artisan::output(), 'inactivo'));
        if (!$active) {
            cache(['service_queue' => 'inactive'], (10*60));
            throw new ServiceException($failMessage);
        }
        cache(['service_queue' => 'active'], (10*60));
    }
}
