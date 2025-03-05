<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Infrastructure\Services;

final class Kalion
{
    public static bool $runMigrations     = false;
    public static bool $publishMigrations = false;
    public static bool $registerRoutes    = true;
    public static bool $preferencesCookie = false;

    public static function setLogChannels(): void
    {
        config([
            'logging.channels.queues' => [
                'driver'               => 'single',
                'path'                 => storage_path('logs/queues.log'),
                'level'                => env('LOG_LEVEL', 'debug'),
                'replace_placeholders' => true,
            ],
            'logging.channels.loads'  => [
                'driver'               => 'single',
                'path'                 => storage_path('logs/loads.log'),
                'level'                => env('LOG_LEVEL', 'debug'),
                'replace_placeholders' => true,
            ]
        ]);
    }

    public static function configure(): self
    {
        return new self();
    }


    public function runMigrations(): self
    {
        self::$runMigrations = true;
        return $this;
    }

    public static function shouldRunMigrations(): bool
    {
        return self::$runMigrations;
    }

    public function publishMigrations(): self
    {
        self::$publishMigrations = true;
        return $this;
    }

    public static function shouldPublishMigrations(): bool
    {
        return self::$publishMigrations;
    }

    public function ignoreRoutes(): self
    {
        self::$registerRoutes = false;
        return $this;
    }

    public static function shouldRegistersRoutes(): bool
    {
        return self::$registerRoutes;
    }

    public function enablePreferencesCookie(): self
    {
        self::$preferencesCookie = true;
        return $this;
    }

    public static function enabledPreferencesCookie(): bool
    {
        return self::$preferencesCookie;
    }
}
