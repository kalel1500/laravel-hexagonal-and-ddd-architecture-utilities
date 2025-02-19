<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Contracts\Repositories;

use Thehouseofel\Hexagonal\Domain\Objects\Entities\PermissionEntity;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelString;

interface PermissionRepositoryContract
{
    public function findByName(ModelString $permission): PermissionEntity;
}
