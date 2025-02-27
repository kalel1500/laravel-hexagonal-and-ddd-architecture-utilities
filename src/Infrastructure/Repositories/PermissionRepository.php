<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Repositories;

use Thehouseofel\Hexagonal\Domain\Contracts\Repositories\PermissionRepositoryContract;
use Thehouseofel\Hexagonal\Domain\Objects\Entities\PermissionEntity;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelString;
use Thehouseofel\Hexagonal\Infrastructure\Models\Permission;

final class PermissionRepository implements PermissionRepositoryContract
{
    private string $model;

    public function __construct()
    {
        $this->model = Permission::class;
    }

    public function findByName(ModelString $permission): PermissionEntity
    {
        $data =  $this->model::query()
            ->with('roles')
            ->where('name', $permission->value())
            ->firstOrFail();
        return PermissionEntity::fromArray($data->toArray(), ['roles']);
    }
}
