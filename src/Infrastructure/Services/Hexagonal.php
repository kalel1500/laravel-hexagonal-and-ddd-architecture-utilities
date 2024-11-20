<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Services;

final class Hexagonal
{
    public static $runsMigrations = true;

    public static $registersRoutes = true;

    public static function setLogChannels(): void
    {
        config([
            'logging.channels.queues' => [
                'driver' => 'single',
                'path' => storage_path('logs/queues.log'),
                'level' => env('LOG_LEVEL', 'debug'),
                'replace_placeholders' => true,
            ],
            'logging.channels.loads' => [
                'driver' => 'single',
                'path' => storage_path('logs/loads.log'),
                'level' => env('LOG_LEVEL', 'debug'),
                'replace_placeholders' => true,
            ]
        ]);
    }

    /**
     * Configure Package to not register its migrations.
     *
     * @return static
     */
    public static function ignoreMigrations(): Hexagonal
    {
        static::$runsMigrations = false;

        return new static;
    }

    /**
     * Configure Package to not register its routes.
     *
     * @return static
     */
    public static function ignoreRoutes(): Hexagonal
    {
        static::$registersRoutes = false;

        return new static;
    }

    /**
     * Determine if Package migrations should be run.
     *
     * @return bool
     */
    public static function shouldRunMigrations(): bool
    {
        return static::$runsMigrations;
    }

    /**
     * Determine if Package migrations should be run.
     *
     * @return bool
     */
    public static function shouldRegistersRoutes(): bool
    {
        return static::$registersRoutes;
    }
}
