<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Services;

final class Hexagonal
{
    public static bool $runsMigrations    = false;
    public static bool $publishMigrations = false;
    public static bool $registersRoutes   = true;
    public static bool $preferencesCookie = false;

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
        self::$runsMigrations = true;
        return $this;
    }

    /**
     * Configure Package to not publish its migrations.
     *
     * @return self
     */
    public function publishMigrations(): self
    {
        self::$publishMigrations = true;
        return $this;
    }

    /**
     * Configure Package to not register its routes.
     *
     * @return self
     */
    public function ignoreRoutes(): self
    {
        self::$registersRoutes = false;
        return $this;
    }

    public function enablePreferencesCookie(): self
    {
        self::$preferencesCookie = true;
        return $this;
    }

    /**
     * Determine if Package migrations should be run.
     *
     * @return bool
     */
    public static function shouldRunMigrations(): bool
    {
        return self::$runsMigrations;
    }

    /**
     * Determine if Package migrations should be run.
     *
     * @return bool
     */
    public static function shouldPublishMigrations(): bool
    {
        return self::$publishMigrations;
    }

    /**
     * Determine if Package migrations should be run.
     *
     * @return bool
     */
    public static function shouldRegistersRoutes(): bool
    {
        return self::$registersRoutes;
    }

    public static function enabledPreferencesCookie(): bool
    {
        return self::$preferencesCookie;
    }
}
