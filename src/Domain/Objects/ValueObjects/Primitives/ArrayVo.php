<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\Contracts\ContractArrayVo;

class ArrayVo extends ContractArrayVo
{
    protected $nullable = false;

    public function __construct(array $value)
    {
        parent::__construct($value);
    }

    public function value(): array
    {
        return $this->value;
    }
}
