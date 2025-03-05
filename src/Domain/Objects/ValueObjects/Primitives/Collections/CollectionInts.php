<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\ValueObjects\Primitives\Collections;

use Thehouseofel\Kalion\Domain\Objects\Collections\Contracts\ContractCollectionVo;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\Primitives\Contracts\ContractIntVo;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\Primitives\IntNullVo;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\Primitives\IntVo;

final class CollectionInts extends ContractCollectionVo
{
    protected const VALUE_CLASS = ContractIntVo::class;
    protected const VALUE_CLASS_REQ = IntVo::class;
    protected const VALUE_CLASS_NULL = IntNullVo::class;

    public function __construct(ContractIntVo ...$items)
    {
        $this->items = $items;
    }
}
