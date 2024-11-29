<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\DataObjects\Layout\Collections;

use Thehouseofel\Hexagonal\Domain\Objects\Collections\Contracts\ContractCollectionDo;
use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\Layout\NavbarItemDo;

final class NavbarItemCollection extends ContractCollectionDo
{
    protected const VALUE_CLASS = NavbarItemDo::class;

    public function __construct(NavbarItemDo ...$items)
    {
        $this->items = $items;
    }
}
