<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\Entities\Collections;

use Thehouseofel\Hexagonal\Domain\Objects\Collections\Contracts\ContractCollectionEntity;
use Thehouseofel\Hexagonal\Domain\Objects\Entities\StateEntity;

final class StateCollection extends ContractCollectionEntity
{
    public const ENTITY = StateEntity::class;

    public function __construct(StateEntity ...$items)
    {
        $this->items = $items;
    }
}
