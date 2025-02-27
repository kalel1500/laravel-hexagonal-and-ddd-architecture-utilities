<?php

namespace Thehouseofel\Hexagonal\Domain\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Thehouseofel\Hexagonal\Infrastructure\Models\Role;

trait ModelHasPermissions
{
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

}
