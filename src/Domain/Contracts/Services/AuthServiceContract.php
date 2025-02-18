<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Contracts\Services;

use Thehouseofel\Hexagonal\Domain\Objects\Entities\UserEntity;

interface AuthServiceContract
{
    public function userEntity(): ?UserEntity;
}
