<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static userEntity()
 */
final class AuthService extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'authService';
    }
}
