<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Services;

use Thehouseofel\Hexagonal\Domain\Contracts\Services\AuthServiceContract;
use Thehouseofel\Hexagonal\Domain\Objects\Entities\UserEntity;

final class AuthService implements AuthServiceContract
{
    private $entityClass;
    private $loadRoles;
    private $userEntity = null;

    public function __construct()
    {
        $this->entityClass = config('hexagonal_auth.entity_class');
        $this->loadRoles = config('hexagonal_auth.load_roles');
    }

    public function userEntity(): ?UserEntity
    {
        if ($this->userEntity) {
            return $this->userEntity;
        }

        $user = auth()->user();
        if (is_null($user)) {
            return null;
        }

        $with = null;
        if ($this->loadRoles) {
            $user->load('roles');
            $with = ['roles'];
        }
        $this->userEntity =  $this->entityClass::fromArray($user->toArray(), $with);
        return $this->userEntity;
    }
}
