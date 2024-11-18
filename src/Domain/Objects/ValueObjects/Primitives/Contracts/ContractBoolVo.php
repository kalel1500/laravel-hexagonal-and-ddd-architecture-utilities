<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\Contracts;

use Thehouseofel\Hexagonal\Domain\Exceptions\InvalidValueException;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\ContractValueObject;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelBool;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelBoolNull;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelDate;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelDateNull;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\BoolNullVo;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\BoolVo;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\DateNullVo;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\DateVo;

abstract class ContractBoolVo extends ContractValueObject
{
    protected const CLASS_REQUIRED = BoolVo::class;
    protected const CLASS_NULLABLE = BoolNullVo::class;
    protected const CLASS_MODEL_REQUIRED = ModelBool::class;
    protected const CLASS_MODEL_NULLABLE = ModelBoolNull::class;

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
        $this->checkNullable($value);

        if (!is_null($value) && !isValidBoolean($value)) {
            throw new InvalidValueException(sprintf('<%s> does not allow the value <%s> as valid boolean.', class_basename(static::class), $value));
        }
    }
}
