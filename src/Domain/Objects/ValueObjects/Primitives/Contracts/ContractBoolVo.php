<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\Contracts;

use Thehouseofel\Hexagonal\Domain\Exceptions\InvalidValueException;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\ContractValueObject;

abstract class ContractBoolVo extends ContractValueObject
{
    public function __construct($value)
    {
        $this->ensureIsValidValue($value);
        $this->value = is_null($value) ? null : boolval($value);
    }

    public function value(): ?bool
    {
        return $this->isNullReceived() ? null : (bool)$this->value;
    }

    public function valueInt(): ?int
    {
        return $this->isNull() ? null : (int)$this->value();
    }

    public function isTrue(): bool
    {
        return $this->value() === true;
    }

    public function isFalse(): bool
    {
        return $this->value() === false;
    }

    private function ensureIsValidValue($value): void
    {
        $this->checkAllowNull($value);

        if (!is_null($value) && !isValidBoolean($value)) {
            throw new InvalidValueException(sprintf('<%s> does not allow the value <%s> as valid boolean.', class_basename(static::class), $value));
        }
    }
}
