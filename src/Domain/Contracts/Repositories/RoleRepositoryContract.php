<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Contracts\Repositories;

use Thehouseofel\Hexagonal\Domain\Objects\Entities\RoleEntity;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelString;

interface RoleRepositoryContract
{
    public function findByName(ModelString $name): RoleEntity;
}
