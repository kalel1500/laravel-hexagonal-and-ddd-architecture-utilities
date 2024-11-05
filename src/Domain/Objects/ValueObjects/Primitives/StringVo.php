<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\Contracts\ContractStringVo;

class StringVo extends ContractStringVo
{
    protected $allowNull = false;

    public function __construct(string $value)
    {
        parent::__construct($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}
