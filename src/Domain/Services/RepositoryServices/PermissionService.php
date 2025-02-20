<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Services\RepositoryServices;

use Thehouseofel\Hexagonal\Domain\Contracts\Repositories\PermissionRepositoryContract;
use Thehouseofel\Hexagonal\Domain\Contracts\Repositories\RoleRepositoryContract;
use Thehouseofel\Hexagonal\Domain\Contracts\Repositories\UserRepositoryContract;
use Thehouseofel\Hexagonal\Domain\Objects\Entities\RoleEntity;
use Thehouseofel\Hexagonal\Domain\Objects\Entities\UserEntity;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelString;

final class PermissionService
{
    private UserRepositoryContract       $repositoryUser;
    private RoleRepositoryContract       $repositoryRole;
    private PermissionRepositoryContract $repositoryPermission;

    public function __construct(
        UserRepositoryContract       $repositoryUser,
        RoleRepositoryContract       $repositoryRole,
        PermissionRepositoryContract $repositoryPermission
    )
    {
        $this->repositoryUser       = $repositoryUser;
        $this->repositoryRole       = $repositoryRole;
        $this->repositoryPermission = $repositoryPermission;
    }

    protected function userHasPermission(UserEntity $user, string $permission): bool
    {
        // Comprobar si el usuario tiene un rol con todos los permisos
        if ($user->all_permissions()) return true;

        // Obtener la Entidad Permission con todos los roles
        $permission = $this->repositoryPermission->findByName(ModelString::new($permission));

        // Recorrer los roles del permiso
        return $permission->roles()->contains(function (RoleEntity $role) use ($user, $permission) {
            // Comprobar si el rol es query y lanzarla o comprobar si el usuario tiene ese rol
            return $role->is_query->value()
                ? $this->repositoryUser->{$role->name->value()}($user)
                : $user->roles()->contains('name', $role->name->value());
        });
    }

    protected function userHasRole(UserEntity $user, string $role): bool
    {
        $role = $this->repositoryRole->findByName(ModelString::new($role));
        return $user->roles()->contains('name', $role->name->value());
    }

    /**
     * @param UserEntity $user
     * @param string|array $permissions
     * @return bool
     */
    public function can(UserEntity $user, $permissions): bool
    {
        $permissions = collect(pipe_str_to_array($permissions));
        return $permissions->contains(fn($permission) => $this->userHasPermission($user, $permission));
    }

    /**
     * @param UserEntity $user
     * @param string|array $roles
     * @return bool
     */
    public function is(UserEntity $user, $roles): bool
    {
        $roles = collect(pipe_str_to_array($roles));
        return $roles->contains(fn($role) => $this->userHasRole($user, $role));
    }

}
