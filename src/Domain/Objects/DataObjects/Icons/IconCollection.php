<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\DataObjects\Icons;

use Thehouseofel\Hexagonal\Domain\Objects\Collections\Contracts\ContractCollectionDo;

final class IconCollection extends ContractCollectionDo
{
    protected const VALUE_CLASS = IconDo::class;

    public function __construct(IconDo ...$items)
    {
        $this->items = $items;
    }
}
