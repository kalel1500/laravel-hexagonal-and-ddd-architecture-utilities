<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects;

use Thehouseofel\Hexagonal\Domain\Exceptions\InvalidValueException;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\Contracts\ContractBoolVo;

/**
 * @template T of ContractValueObject
 */
abstract class ContractValueObject
{
    protected const IS_MODEL = false;
    protected const CLASS_REQUIRED = null;
    protected const CLASS_NULLABLE = null;
    protected const CLASS_MODEL_REQUIRED = null;
    protected const CLASS_MODEL_NULLABLE = null;

    protected $allowNull = true;
    protected $reasonNullNotAllowed = null;

    protected $mustBeNull = false;
    protected $reasonMustBeNull = null;

    protected $value;

    /**
     * @return T
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

    /**
     * @return T
     */
    public function toUppercase()
    {
        if ($this->isNotNull()) {
            $this->value = strtoupper($this->value);
        }
        return $this;
    }

    /**
     * @return T
     */
    public function toLowercase()
    {
        if ($this->isNotNull()) {
            $this->value = strtolower($this->value);
        }
        return $this;
    }

    /**
     * @return T
     */
    public function toCamelCase()
    {
        if ($this->isNotNull()) {
            $this->value = strToCamelCase($this->value);
        }
        return $this;
    }

    /**
     * @return T
     */
    public function toNoSpaces()
    {
        if ($this->isNotNull()) {
            $this->value = str_replace(' ', '', $this->value);
        }
        return $this;
    }

    /**
     * @return T
     */
    public function toCleanString()
    {
        if ($this->isNotNull()) {
            // Eliminar acentos y convertir a caracteres sin tildes
            $this->value = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $this->value);

            // Eliminar caracteres especiales excepto letras y números
            $this->value = preg_replace('/[^A-Za-z0-9 ]/', '', $this->value);
        }
        return $this;
    }

    /**
     * @return T
     */
    public function toNull()
    {
        $class = static::IS_MODEL ? static::CLASS_MODEL_NULLABLE : static::CLASS_NULLABLE;
        return $class::new($this->value);
    }

    /**
     * @return T
     */
    public function toNotNull()
    {
        $class = static::IS_MODEL ? static::CLASS_MODEL_REQUIRED : static::CLASS_REQUIRED;
        return $class::new($this->value);
    }

    protected function checkAllowNull($value): void
    {
        // Si se permite NULL convertir '' a null
        $value = ($this->allowNull && empty($value)) ? null : $value;

        // Si NO permite NULL y es NULL -> throw
        if (!$this->allowNull && is_null($value)) {
            $reason = is_null($this->reasonNullNotAllowed)
                ? sprintf('<%s> does not allow the value <%s>.', class_basename(static::class), 'null')
                : $this->reasonNullNotAllowed;
            throw new InvalidValueException($reason);
        }

        // Si debe ser NULL y NO es NULL -> throw
        if ($this->mustBeNull && !is_null($value)) {
            $reason = is_null($this->reasonMustBeNull)
                ? sprintf('<%s> must be null on this case.', class_basename(static::class))
                : $this->reasonMustBeNull;
            throw new InvalidValueException($reason);
        }

        // Si NO es BoolVo && NO es NULL && es '' -> throw
        if (!($this instanceof ContractBoolVo) && !is_null($value) && empty($value)) {
            throw new InvalidValueException(sprintf('<%s> does not allow an empty value.', class_basename(static::class)));
        }
    }

    public function __toString()
    {
        return (string)$this->value() ?? '';
    }
}
