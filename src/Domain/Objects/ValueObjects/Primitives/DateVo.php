<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\Contracts\ContractDateVo;

class DateVo extends ContractDateVo
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
