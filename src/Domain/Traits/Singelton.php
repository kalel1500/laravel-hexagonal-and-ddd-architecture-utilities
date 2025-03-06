<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Traits;

trait Singelton
{
    private static $instance;

    public static function instance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
    }

}
