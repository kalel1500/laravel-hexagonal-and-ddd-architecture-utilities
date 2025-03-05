<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields\Collections;

use Thehouseofel\Kalion\Domain\Objects\Collections\Contracts\ContractCollectionVo;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields\Contracts\ContractModelId;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields\ModelId;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields\ModelIdNull;

final class CollectionModelId extends ContractCollectionVo
{
    protected const VALUE_CLASS = ContractModelId::class;
    protected const VALUE_CLASS_REQ = ModelId::class;
    protected const VALUE_CLASS_NULL = ModelIdNull::class;

    public function __construct(ContractModelId ...$items)
    {
        $this->items = $items;
    }
}
