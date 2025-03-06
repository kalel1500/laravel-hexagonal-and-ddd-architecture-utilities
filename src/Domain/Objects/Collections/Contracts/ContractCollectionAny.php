<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\Collections\Contracts;

use Thehouseofel\Kalion\Domain\Contracts\Relatable;

abstract class ContractCollectionAny extends ContractCollectionBase implements Relatable
{
    protected const IS_ENTITY = false;
    protected const VALUE_CLASS = 'any';
    protected const VALUE_CLASS_REQ = 'any';
    protected const VALUE_CLASS_NULL = 'any';

    protected $with = null;
    protected $isFull = null;

    /**
     * @param array|null $values
     * @param string|array|null $with
     * @param bool|string|null $isFull
     * @return static // TODO PHP8 static return type
     */
    static function fromArray(?array $values, $with = null, $isFull = null)
    {
        if (is_null($values)) return null;
        $collection = new static($values);
        $collection->with = $with;
        $collection->isFull = $isFull;
        return $collection;
    }
}
