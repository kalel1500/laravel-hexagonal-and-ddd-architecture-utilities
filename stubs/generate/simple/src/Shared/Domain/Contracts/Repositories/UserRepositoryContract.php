<?php

declare(strict_types=1);

namespace Src\Shared\Domain\Contracts\Repositories;

use Src\Shared\Domain\Objects\Entities\UserEntity;

interface UserRepositoryContract
{
    public function is_important_group(UserEntity $user): bool;
}
