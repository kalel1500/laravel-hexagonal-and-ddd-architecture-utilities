<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Services;

final class Version
{
    /**
     * Determinar si la version actual de PHP es igual o mayor a la 7.4
     *
     * @return bool
     */
    public static function phpMin74(): bool
    {
        return version_compare(PHP_VERSION, '7.4', '>=');
    }

    /**
     * Determinar si la version de Laravel instalada es igual o mayor a la 11
     *
     * @return bool
     */
    public static function laravelMin11(): bool
    {
        return version_compare(app()->version(), '11', '>=');
    }

    /**
     * Determinar si la version de Laravel instalada es igual o mayor a la 9
     *
     * @return bool
     */
    public static function laravelMin9(): bool
    {
        return version_compare(app()->version(), '9', '>=');
    }
}