<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\Entities\Collections;

use Thehouseofel\Kalion\Domain\Objects\Collections\Contracts\ContractCollectionEntity;
use Thehouseofel\Kalion\Domain\Objects\Entities\JobEntity;

class JobCollection extends ContractCollectionEntity
{
    public const ENTITY = JobEntity::class;

    public function __construct(JobEntity ...$items)
    {
        $this->items = $items;
    }
}
