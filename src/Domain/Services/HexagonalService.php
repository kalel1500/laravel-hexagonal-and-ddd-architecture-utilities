<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Services;

final class HexagonalService
{
    public static $runsMigrations = true;

    public static $registersRoutes = true;


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


    /**
     * Configure Package to not register its migrations.
     *
     * @return static
     */
    public static function ignoreMigrations(): HexagonalService
    {
        static::$runsMigrations = false;

        return new static;
    }


    /**
     * Configure Package to not register its routes.
     *
     * @return static
     */
    public static function ignoreRoutes(): HexagonalService
    {
        static::$registersRoutes = false;

        return new static;
    }

}
