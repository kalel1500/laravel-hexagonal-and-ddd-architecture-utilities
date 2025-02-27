<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\Entities\Collections;

use Thehouseofel\Hexagonal\Domain\Objects\Collections\Contracts\ContractCollectionEntity;
use Thehouseofel\Hexagonal\Domain\Objects\Entities\PermissionEntity;

final class PermissionCollection extends ContractCollectionEntity
{
    public const ENTITY = PermissionEntity::class;

    public function __construct(PermissionEntity ...$items)
    {
        $this->items = $items;
    }
}
