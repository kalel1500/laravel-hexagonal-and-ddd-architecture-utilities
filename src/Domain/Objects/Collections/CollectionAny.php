<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\Collections;

use Thehouseofel\Kalion\Domain\Objects\Collections\Contracts\ContractCollectionAny;

final class CollectionAny extends ContractCollectionAny
{
    public function __construct($items = null)
    {
        $this->items = (is_null($items)) ? [] : $items;
    }
}
