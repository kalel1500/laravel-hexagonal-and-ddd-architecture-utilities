<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\Contracts;

use Thehouseofel\Hexagonal\Domain\Exceptions\InvalidValueException;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\ContractValueObject;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\IntVo;

abstract class ContractIntVo extends ContractValueObject
{
    public function __construct(?int $value)
    {
        $this->ensureIsValidValue($value);
        $this->value = $value;
    }

    public function value(): ?int
    {
        return $this->value;
    }

    public function isBiggerThan(int $number): bool
    {
        $other = new IntVo($number);
        return $this->value() > $other->value();
    }

    public function isLessThan(int $number): bool
    {
        $other = new IntVo($number);
        return $this->value() < $other->value();
    }

    public function equals(int $number): bool
    {
        $other = new IntVo($number);
        return $this->value() === $other->value();
    }

    public function isBiggerOrEqualThan(int $number): bool
    {
        $other = new IntVo($number);
        return $this->value() >= $other->value();
    }

    public function isLessOrEqualThan(int $number): bool
    {
        $other = new IntVo($number);
        return $this->value() <= $other->value();
    }

    private function ensureIsValidValue(?int $value): void
    {
        $this->checkAllowNull($value);

        if (!is_null($value) && $value < 0) {
            throw new InvalidValueException(sprintf('<%s> does not allow the value <%s>.', class_basename(static::class), $value));
        }
    }
}
