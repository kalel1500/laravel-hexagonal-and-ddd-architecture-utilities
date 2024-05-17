<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\Contracts;

use Thehouseofel\Hexagonal\Domain\Exceptions\InvalidValueException;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\ContractValueObject;

abstract class ContractJsonVo extends ContractValueObject
{
    protected $allowStringInformatable = true;

    protected $arrayValue = null;
    protected $objectValue = null;
    protected $encodedValue = null;
    protected $failAtFormat = false;

    public function __construct($value)
    {
        $this->ensureIsValidValue($value);
        $this->setValues($value);
        $this->value = $value;
    }

    protected function ensureIsValidValue($value): void
    {
        $this->checkAllowNull($value);

        if (!empty($value) && (!is_string($value) && !is_array($value) && !is_object($value))) {
            throw new InvalidValueException(sprintf('<%s> must have a value of type string object or array.', class_basename(static::class)));
        }
    }

    protected function setValues($value): void
    {
        if (empty($value)) return;

        if (is_string($value)) {
            $this->arrayValue = stringToArray($value);
            $this->objectValue = stringToObject($value);
            $this->encodedValue = $value;
            if (is_null($this->objectValue)) {
                $this->failAtFormat = true;
                $this->encodedValue = json_encode($value);
                if (!$this->allowStringInformatable) {
                    throw new InvalidValueException(sprintf('Invalid JSON passed to constructor of class <%s>.', class_basename(static::class)));
                }
            }
        }

        if (is_array($value) || is_object($value)) {
            $this->arrayValue = objectToArray($value);
            $this->objectValue = arrayToObject($value);
            $this->encodedValue = json_encode($value);
        }
    }

    /**
     * @return null|array|object|string // TODO PHP8 - union types
     */
    public function value()
    {
        return $this->value;
    }

    public function valueArray(): ?array
    {
        return $this->arrayValue;
    }

    /**
     * @return array|object|null // TODO PHP8 - union types
     */
    public function valueObj()
    {
        return $this->objectValue;
    }

    public function valueEncoded(): ?string
    {
        return $this->encodedValue;
    }

    public function failAtFormat(): bool
    {
        return $this->failAtFormat;
    }

    public function isNull(): bool
    {
        return is_null($this->value);
    }

    public function isEmpty(): bool
    {
        return empty($this->value);
    }

    public function isNullStrict(): bool
    {
        return (is_null($this->arrayValue) || is_null($this->objectValue) || is_null($this->encodedValue));
    }

    public function isEmptyStrict(): bool
    {
        return (empty($this->arrayValue) || empty($this->objectValue) || empty($this->encodedValue));
    }


    /*----------------------------------------------------------------------------------------------------------------------------------------------*/
    /*----------------------------------------------------------------MODIFIERS---------------------------------------------------------------------*/


    /**
     * @return $this // TODO PHP8 static return type
     */
    public function toArray()
    {
        $this->value = $this->arrayValue;
        return $this;
    }

    /**
     * @return $this // TODO PHP8 static return type
     */
    public function toObject()
    {
        $this->value = $this->objectValue;
        return $this;
    }

    /**
     * @return $this // TODO PHP8 static return type
     */
    public function encode()
    {
        $this->value = $this->encodedValue;
        return $this;
    }

}
