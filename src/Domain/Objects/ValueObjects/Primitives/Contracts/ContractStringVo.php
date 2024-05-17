<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\Contracts;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\ContractValueObject;

abstract class ContractStringVo extends ContractValueObject
{
    public function __construct(?string $value)
    {
        $this->ensureIsValidValue($value);
        $this->value = $value;
    }

    public function value(): ?string
    {
        return $this->value;
    }

    protected function ensureIsValidValue(?string $value): void
    {
        $this->checkAllowNull($value);
    }

    public function contains(string $search): bool
    {
        return str_contains($this->value(), $search);
    }
}
