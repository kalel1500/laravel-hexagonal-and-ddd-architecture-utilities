<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Services;

use Thehouseofel\Hexagonal\Domain\Contracts\Services\AuthServiceContract;
use Thehouseofel\Hexagonal\Domain\Objects\Entities\UserEntity;

/**
 * @template T of UserEntity
 */
final class AuthService implements AuthServiceContract
{
    /** @var class-string<T> */
    private $entityClass;

    private $loadRoles;

    /** @var T|null */
    private $userEntity = null;

    public function __construct()
    {
        $this->entityClass = config('hexagonal_auth.entity_class');
        $this->loadRoles = config('hexagonal_auth.load_roles');
    }

    /**
     * @return T|null
     */
    public function userEntity()
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
