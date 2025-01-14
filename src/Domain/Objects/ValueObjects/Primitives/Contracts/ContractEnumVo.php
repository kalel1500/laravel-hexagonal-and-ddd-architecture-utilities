<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\Contracts;

use Thehouseofel\Hexagonal\Domain\Exceptions\InvalidValueException;
use Thehouseofel\Hexagonal\Domain\Exceptions\RequiredDefinitionException;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\ContractValueObject;

abstract class ContractEnumVo extends ContractValueObject
{
    protected $permittedValues = null;
    protected $caseSensitive = true;
    protected $translatedValues = null;

    public function __construct($value)
    {
        if (is_null($this->getPermittedValues())) {
            throw new RequiredDefinitionException(sprintf('<%s> needs to define <%s> %s.', class_basename(static::class), '$permittedValues', 'property'));
        }
        $this->ensureIsValidValue($value);
        $this->value = $value;
    }

    public function value(): ?string
    {
        return $this->value;
    }

    protected function ensureIsValidValue(?string $value): void
    {
        $this->checkNullable($value);
        $this->checkPermittedValues($value);
    }

    protected function checkPermittedValues(?string $value)
    {
        $permittedValues = $this->getPermittedValues();
        $failPermittedValuesValidation = ($this->caseSensitive)
            ? (!in_array($value, $permittedValues))
            : (!in_array(strtolower($value), array_map('strtolower', $permittedValues)));
        if (!is_null($value) && $failPermittedValuesValidation) {
            $permittedValuesString = '['.implode(', ', $permittedValues).']';
            throw new InvalidValueException(sprintf('<%s> no permite el valor <%s>. Valores permitidos: <%s>', class_basename(static::class), $value, $permittedValuesString));
        }
    }

    protected function getPermittedValues(): ?array
    {
        return $this->permittedValues;
    }

    public function translatedValue(bool $ucfirst = false): ?string
    {
        if (!is_array($this->translatedValues)) {
            throw new RequiredDefinitionException(sprintf('<%s> necesita definir la variable <$translatedValues>', class_basename(static::class)));
        }
        if ($this->isNull()) {
            return null;
        }
        $value = $this->translatedValues[$this->value()];
        return ($ucfirst) ? ucfirst($value): $value;
    }

}
