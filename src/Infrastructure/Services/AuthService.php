<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Services;

use Thehouseofel\Hexagonal\Domain\Contracts\Services\AuthServiceContract;

final class AuthService implements AuthServiceContract
{
    private $entityClass;
    private $userEntity = null;

    public function __construct()
    {
        $this->entityClass = config('hexagonal_user.entity_class');
    }

    public function userEntity()
    {
        if (!$this->userEntity) {
            $this->userEntity =  $this->entityClass::fromArray(auth()->user()->toArray());
        }

        return $this->userEntity;
    }
}
