<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Services;

use Illuminate\Support\Collection;

final class PermissionParser
{
    public static function new(): self
    {
        return new self();
    }

    /**
     * @param string|array $permissions
     * @param array $params
     * @return Collection
     */
    public function getArrayPermissions($permissions, array $params): Collection
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
}