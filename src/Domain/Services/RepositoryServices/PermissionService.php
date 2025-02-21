<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Services\RepositoryServices;

use Illuminate\Support\Collection;
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

    /**
     * @param UserEntity $user
     * @param string|array $permissions
     * @param array $params
     * @return bool
     */
    public function can(UserEntity $user, $permissions, array $params): bool
    {
        $array_permissions = $this->getArrayPermissions($permissions, $params);
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
        $array_roles = $this->getArrayPermissions($roles, $params);
        return $array_roles->contains(fn($params, $role) => $this->userHasRole($user, $role, $params));
    }

    /**
     * @param string|array $permissions
     * @param array $params
     * @return Collection
     */
    private function getArrayPermissions($permissions, array $params): Collection
    {
        $permissions  = collect(is_array($permissions) ? $permissions : explode('|', $permissions));
        $stringParams = empty($params);

        if ($stringParams) {
            $array_permissions = $permissions
                ->mapWithKeys(function ($permission) {
                    $parts = explode(':', $permission, 2);
                    $permission_name = $parts[0];
                    $permission_params = $parts[1] ?? null;

                    $params = is_null($permission_params)
                        ? []
                        : collect(explode(';', $permission_params))
                            ->map(function ($param) {
                                $paramValues = explode(',', $param);
                                $isOneValue  = count($paramValues) === 1;
                                return $isOneValue
                                    ? (is_numeric($paramValues[0])
                                        ? intval($paramValues[0])
                                        : $paramValues[0]
                                    )
                                    : array_map((fn($paramValue) => is_numeric($paramValue) ? intval($paramValue) : $paramValue), $paramValues);
                            })
                            ->toArray();

                    return [$permission_name => $params];
                });
        } else {
            $array_permissions = collect($permissions)
                ->mapWithKeys(function ($permission, $key) use ($params) {
                    $permission_params = $params[$key] ?? null;

                    $permission_params = is_null($permission_params) || (is_array($permission_params) && empty(array_filter($permission_params, fn($param) => !is_null($param))))
                        ? []
                        : (
                        !is_array($permission_params)
                            ? [$permission_params]
                            : (
                        is_array($permission_params[0])
                            ? $permission_params
                            : [$permission_params]
                        )
                        );
                    return [$permission => $permission_params];
                });
        }

        return $array_permissions;
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
