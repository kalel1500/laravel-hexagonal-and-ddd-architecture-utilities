<?php

declare(strict_types=1);

use Src\Shared\Domain\Objects\Entities\UserEntity;
use Thehouseofel\Hexagonal\Infrastructure\Facades\AuthService;

if (!function_exists('userEntity')) {
    /**
     * Este helper se crea en la aplicación (y no en el paquete) para indicar el return es de tipo UserEntity
     *
     * @return UserEntity
     */
    function userEntity(): UserEntity
    {
        return AuthService::userEntity();
    }
}
