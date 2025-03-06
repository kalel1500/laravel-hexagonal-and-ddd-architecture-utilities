<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Contracts\Repositories;

use Thehouseofel\Kalion\Domain\Objects\Entities\UserEntity;

interface UserRepositoryContract
{
    public function find(int $id): UserEntity;
}
