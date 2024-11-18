<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\Contracts;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\ContractValueObject;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelString;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelStringNull;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\StringNullVo;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\StringVo;

abstract class ContractStringVo extends ContractValueObject
{
    protected const CLASS_REQUIRED = StringVo::class;
    protected const CLASS_NULLABLE = StringNullVo::class;
    protected const CLASS_MODEL_REQUIRED = ModelString::class;
    protected const CLASS_MODEL_NULLABLE = ModelStringNull::class;

    public function __construct(?string $value)
    {
        $this->ensureIsValidValue($value);
        $this->value = $value; // $this->clearString($value);
    }

    public function value(): ?string
    {
        return $this->value;
    }

    protected function ensureIsValidValue(?string $value): void
    {
        $this->checkNullable($value);
    }

    /*protected function clearString(?string $value): ?string
    {
        return is_null($value) || empty(trim($value)) ? null : trim($value);
    }*/

    public function contains(string $search): bool
    {
        return str_contains($this->value(), $search);
    }
}
