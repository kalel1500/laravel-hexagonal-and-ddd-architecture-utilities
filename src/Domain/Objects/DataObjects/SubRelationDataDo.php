<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\DataObjects;

final class SubRelationDataDo extends ContractDataObject
{
    private $with;
    private $isFull;

    public function __construct($with, $isFull)
    {
        $this->with = $with;
        $this->isFull = $isFull;
    }

    public function with()
    {
        return $this->with;
    }

    public function isFull()
    {
        return $this->isFull;
    }
}