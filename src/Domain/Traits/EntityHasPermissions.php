<?php

namespace Thehouseofel\Hexagonal\Domain\Traits;

use Thehouseofel\Hexagonal\Domain\Objects\Entities\Collections\RoleCollection;
use Thehouseofel\Hexagonal\Domain\Objects\Entities\RoleEntity;
use Thehouseofel\Hexagonal\Domain\Services\RepositoryServices\PermissionService;

trait EntityHasPermissions
{
    public function can($permission): bool
    {
        return app()->make(PermissionService::class)->can($this, $permission);
    }

    public function is($role): bool
    {
        return app()->make(PermissionService::class)->is($this, $role);
    }

    /*----------------------------------------------------------------------------------------------------------------*/
    /*--------------------------------------------------- Relations -------------------------------------------------*/

    public function roles(): RoleCollection
    {
        return $this->getRelation('roles');
    }

    public function setRoles(array $value): void
    {
        $this->setRelation($value, 'roles', RoleCollection::class);
    }


    /*----------------------------------------------------------------------------------------------------------------*/
    /*--------------------------------------------------- Properties -------------------------------------------------*/

    public function all_permissions(): bool
    {
        return $this->roles()->contains(fn(RoleEntity $role) => $role->all_permissions->isTrue());
    }
}
