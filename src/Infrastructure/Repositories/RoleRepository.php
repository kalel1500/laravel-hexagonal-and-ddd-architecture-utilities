<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Repositories;

use Thehouseofel\Hexagonal\Domain\Contracts\Repositories\RoleRepositoryContract;
use Thehouseofel\Hexagonal\Domain\Objects\Entities\RoleEntity;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelString;
use Thehouseofel\Hexagonal\Infrastructure\Models\Role;

final class RoleRepository implements RoleRepositoryContract
{
    private string $model;

    public function __construct()
    {
        $this->model = Role::class;
    }

    public function findByName(ModelString $name): RoleEntity
    {
        $data = $this->model::query()
            ->where('name', $name->value())
            ->firstOrFail();
        return RoleEntity::fromArray($data->toArray());
    }
}
