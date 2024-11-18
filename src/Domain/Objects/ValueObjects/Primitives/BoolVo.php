<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\Contracts\ContractBoolVo;

class BoolVo extends ContractBoolVo
{
    protected $nullable = false;

    public function value(): bool
    {
        return (bool)$this->value;
    }

    public function valueInt(): int
    {
        return (int)$this->value();
    }
}
