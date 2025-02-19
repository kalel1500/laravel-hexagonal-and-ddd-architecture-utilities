<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Contracts\Services;

use Thehouseofel\Hexagonal\Domain\Objects\Entities\UserEntity;

/**
 * @template T of UserEntity
 */
interface AuthServiceContract
{
    /**
     * @return T|null
     */
    public function userEntity();
}
