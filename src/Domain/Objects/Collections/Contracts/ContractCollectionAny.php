<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\Collections\Contracts;

abstract class ContractCollectionAny extends ContractCollectionBase
{
    protected const IS_ENTITY = false;
    protected const VALUE_CLASS = 'any';
    protected const VALUE_CLASS_REQ = 'any';
    protected const VALUE_CLASS_NULL = 'any';

    protected $with = null;

    static function fromArray(?array $values, ?array $with = null)
    {
        $values = $values ?? [];
        $collection = new static($values);
        $collection->with = $with;
        return $collection;
    }
}
