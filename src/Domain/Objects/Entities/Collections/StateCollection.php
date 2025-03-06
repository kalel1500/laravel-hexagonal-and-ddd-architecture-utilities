<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\Entities\Collections;

use Thehouseofel\Kalion\Domain\Objects\Collections\Contracts\ContractCollectionEntity;
use Thehouseofel\Kalion\Domain\Objects\Entities\StateEntity;

class StateCollection extends ContractCollectionEntity
{
    public const ENTITY = StateEntity::class;

    public function __construct(StateEntity ...$items)
    {
        $this->items = $items;
    }
}
