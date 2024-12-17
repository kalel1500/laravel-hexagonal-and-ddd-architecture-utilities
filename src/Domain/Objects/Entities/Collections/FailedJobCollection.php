<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\Entities\Collections;

use Thehouseofel\Hexagonal\Domain\Objects\Collections\Contracts\ContractCollectionEntity;
use Thehouseofel\Hexagonal\Domain\Objects\Entities\FailedJobEntity;

class FailedJobCollection extends ContractCollectionEntity
{
    public const ENTITY = FailedJobEntity::class;

    public function __construct(FailedJobEntity ...$items)
    {
        $this->items = $items;
    }
}
