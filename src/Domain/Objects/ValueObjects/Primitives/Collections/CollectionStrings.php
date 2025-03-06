<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\ValueObjects\Primitives\Collections;

use Thehouseofel\Kalion\Domain\Objects\Collections\Contracts\ContractCollectionVo;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\Primitives\Contracts\ContractStringVo;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\Primitives\StringNullVo;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\Primitives\StringVo;

final class CollectionStrings extends ContractCollectionVo
{
    protected const VALUE_CLASS = ContractStringVo::class;
    protected const VALUE_CLASS_REQ = StringVo::class;
    protected const VALUE_CLASS_NULL = StringNullVo::class;

    public function __construct(ContractStringVo ...$items)
    {
        $this->items = $items;
    }
}
