<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects;

use Thehouseofel\Hexagonal\Domain\Exceptions\InvalidValueException;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\Contracts\ContractBoolVo;

abstract class ContractValueObject
{
    protected $allowNull = true;
    protected $reasonNullNotAllowed = null;

    protected $mustBeNull = false;
    protected $reasonMustBeNull = null;

    protected $value;

    /**
     * @return static // TODO PHP8 static return type
     */
    public static function new($value)
    {
        return new static($value);
    }

    abstract public function value();

    protected function isNullReceived(): bool
    {
        return is_null($this->value);
    }

    public function isNull(): bool
    {
        return is_null($this->value());
    }

    public function isNotNull(): bool
    {
        return !$this->isNull();
    }

    public function toUppercase(): ?string
    {
        return ($this->isNull()) ? null : strtoupper($this->value());
    }

    public function toLowercase(): ?string
    {
        return ($this->isNull()) ? null : strtolower($this->value());
    }

    protected function checkAllowNull($value): void
    {
        $value = ($this->allowNull && empty($value)) ? null : $value;
        if (!$this->allowNull && is_null($value)) {
            $reason = is_null($this->reasonNullNotAllowed)
                ? sprintf('<%s> does not allow the value <%s>.', class_basename(static::class), 'null')
                : $this->reasonNullNotAllowed;
            throw new InvalidValueException($reason);
        }
        if ($this->mustBeNull && !is_null($value)) {
            $reason = is_null($this->reasonMustBeNull)
                ? sprintf('<%s> must be null on this case.', class_basename(static::class))
                : $this->reasonMustBeNull;
            throw new InvalidValueException($reason);
        }
        if (!($this instanceof ContractBoolVo) && !is_null($value) && empty($value)) {
            throw new InvalidValueException(sprintf('<%s> does not allow an empty value.', class_basename(static::class)));
        }
    }

    public function __toString()
    {
        return (string)$this->value() ?? '';
    }
}
