<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Contracts\Repositories;

use Thehouseofel\Hexagonal\Domain\Objects\Entities\UserEntity;

interface UserRepositoryContract
{
    public function find(int $id): UserEntity;
}
