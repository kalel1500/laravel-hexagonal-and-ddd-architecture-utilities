<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Services;

use Thehouseofel\Hexagonal\Domain\Contracts\Repositories\PermissionRepositoryContract;
use Thehouseofel\Hexagonal\Domain\Contracts\Repositories\RoleRepositoryContract;
use Thehouseofel\Hexagonal\Domain\Contracts\Repositories\UserRepositoryContract;
use Thehouseofel\Hexagonal\Domain\Objects\Entities\RoleEntity;
use Thehouseofel\Hexagonal\Domain\Objects\Entities\UserEntity;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelString;

final class AuthorizationService
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

    /**
     * @param UserEntity $user
     * @param string|array $permissions
     * @param array $params
     * @return bool
     */
    public function can(UserEntity $user, $permissions, array $params): bool
    {
        $array_permissions = PermissionParser::new()->getArrayPermissions($permissions, $params);
        return $array_permissions->contains(fn($params, $permission) => $this->userHasPermission($user, $permission, $params));
    }

    /**
     * @param UserEntity $user
     * @param string|array $roles
     * @param array $params
     * @return bool
     */
    public function is(UserEntity $user, $roles, array $params): bool
    {
        $array_roles = PermissionParser::new()->getArrayPermissions($roles, $params);
        return $array_roles->contains(fn($params, $role) => $this->userHasRole($user, $role, $params));
    }

    protected function userHasPermission(UserEntity $user, string $permission, array $params = []): bool
    {
        // Comprobar si el usuario tiene un rol con todos los permisos
        if ($user->all_permissions()) return true;

        // Obtener la Entidad Permission con todos los roles
        $permission = $this->repositoryPermission->findByName(ModelString::new($permission));

        // Recorrer los roles del permiso
        return $permission->roles()->contains(function (RoleEntity $role) use ($user, $permission, $params) {
            // Comprobar si el rol es query y lanzarla o comprobar si el usuario tiene ese rol
            return $role->is_query->isTrue()
                ? $this->repositoryUser->{$role->name->value()}($user, ...$params)
                : $user->roles()->contains('name', $role->name->value());
        });
    }

    protected function userHasRole(UserEntity $user, string $role, array $params = []): bool
    {
        $role = $this->repositoryRole->findByName(ModelString::new($role));
        return $user->roles()->contains(function (RoleEntity $userRole) use ($user, $role, $params) {
            if ($userRole->name->value() !== $role->name->value()) return false;
            if ($userRole->is_query->isTrue()) return $this->repositoryUser->{$role->name->value()}($user, ...$params);
            return true;
        });
    }

}
