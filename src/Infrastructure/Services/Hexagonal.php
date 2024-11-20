<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Services;

final class Hexagonal
{
    public static $runsMigrations = false;
    public static $registersRoutes = true;
    public static $preferencesCookie = false;

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

    public static function configure(): self
    {
        return new self();
    }

    /**
     * Configure Package to not register its migrations.
     *
     * @return self
     */
    public function runMigrations(): self
    {
        static::$runsMigrations = true;
        return $this;
    }

    /**
     * Configure Package to not register its routes.
     *
     * @return self
     */
    public function ignoreRoutes(): self
    {
        static::$registersRoutes = false;
        return $this;
    }

    public function enablePreferencesCookie(): self
    {
        static::$preferencesCookie = true;
        return $this;
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

    public static function enabledPreferencesCookie(): bool
    {
        return static::$preferencesCookie;
    }
}
