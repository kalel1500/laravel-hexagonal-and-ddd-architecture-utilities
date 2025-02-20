<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Thehouseofel\Hexagonal\Domain\Objects\Entities\UserEntity;

class UnauthorizedException extends HttpException
{

    public static function forRoles(string $roles): self
    {
        $message = __('h::auth.invalid_roles');

        if (config('hexagonal_auth.display_role_in_exception')) {
            $message .= ' '.__('h::auth.necessary_roles', ['roles' => $roles]);
        }

        return new static(403, $message);
    }

    public static function forPermissions(string $permissions): self
    {
        $message = __('h::auth.invalid_permissions');

        if (config('hexagonal_auth.display_permission_in_exception')) {
            $message .= ' '.__('h::auth.necessary_permissions', ['permissions' => $permissions]);
        }

        return new static(403, $message);
    }

    public static function missingTraitHasPermissions(UserEntity $user): self
    {
        $class = get_class($user);

        return new static(403, __('h::auth.missing_trait_has_roles', ['class' => $class]));
    }

    public static function notLoggedIn(): self
    {
        return new static(403, __('h::auth.not_logged_in'));
    }

}
