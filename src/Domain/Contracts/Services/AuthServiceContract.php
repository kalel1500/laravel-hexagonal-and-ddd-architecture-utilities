<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Contracts\Services;

use Thehouseofel\Kalion\Domain\Objects\Entities\UserEntity;

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
