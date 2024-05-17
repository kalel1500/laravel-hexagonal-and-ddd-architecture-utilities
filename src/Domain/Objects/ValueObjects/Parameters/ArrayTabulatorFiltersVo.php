<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Parameters;

use Thehouseofel\Hexagonal\Domain\Exceptions\InvalidValueException;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\Contracts\ContractArrayVo;
use Thehouseofel\Hexagonal\Infrastructure\Helpers\MyCarbon;

final class ArrayTabulatorFiltersVo extends ContractArrayVo
{
    private const MAX_DAYS_TO_FILTER_RANGE = 50;
    protected $filterTimeName; // TODO PHP8 - type -> string|null
    protected $stringValue = null; // TODO PHP8 - type -> string|null

    /**
     * @param array|string|null $value
     * @param string $filterTimeName
     * @param bool $isRequired
     * @param bool $isRequiredFilterTime
     */
    public function __construct(
        $value,
        string $filterTimeName = 'null',
        bool $isRequired = false,
        bool $isRequiredFilterTime = false
    )
    {
        // Comprobar que sea string, array o null
        $this->checkTypes($value);

        // Setear valores
        $this->filterTimeName   = $filterTimeName;
        $this->stringValue      = (is_array($value))    ? $this->encodeFilters($value) : $value;
        $arrayValue             = (is_string($value))   ? $this->decodeFilters($value) : $value;

        // Comprobar estructura filtros
        $this->checkIsValidArray($arrayValue, $isRequired);

        // Guardar valor
        parent::__construct($arrayValue);

        // Comprobar si existe un filtro de tiempo
        $this->checkFilterTime($isRequiredFilterTime);
    }

    /**
     * @param array|string|null $value
     * @return void
     */
    private function checkTypes($value): void
    {
        if (!is_null($value) && !is_string($value) && !is_array($value)) {
            $type = gettype($value);
            throw new InvalidValueException(sprintf('<%s> espera un valor de tipo string, array o null. <%s> recibido', class_basename(self::class), $type));
        }
    }

    private function checkIsValidArray(?array $value, bool $isRequired): void
    {
        if ($isRequired && is_null($value)) {
            throw new InvalidValueException('Para realizar esta acción es necesario haber filtrado primero');
        }
        if (is_null($value)) {
            return;
        }

        $isValid = true;
        foreach ($value as $item) {
            if (!array_key_exists('field',$item)) $isValid = false;
            if (!array_key_exists('type',$item)) $isValid = false;
            if (!array_key_exists('value',$item)) $isValid = false;
        }
        if (!$isValid) {
            throw new InvalidValueException(sprintf('<%s> espera que cada registro sea un array con los valores [field, type, value].', class_basename(self::class)));
        }
    }

    private function checkFilterTime(bool $isRequiredFilterTime): void
    {
        if ($isRequiredFilterTime && $this->isEmptyFilterTime()) {
            throw new InvalidValueException('Para realizar esta acción es necesario haber filtrado por fecha');
        }
        $filterTime = $this->getFilterTime($this->filterTimeName);
        if ($isRequiredFilterTime && $filterTime) {
            $start = MyCarbon::parse($filterTime['value']['start']);
            $end = MyCarbon::parse($filterTime['value']['end']) ?? MyCarbon::now();
            if (is_null($start)) {
                throw new InvalidValueException('Para realizar esta acción es necesario indicar la fecha de inicio');
            }
            $interval = $start->diff($end);
            if ($interval->days > self::MAX_DAYS_TO_FILTER_RANGE) {
                throw new InvalidValueException(sprintf('Para realizar esta acción el rango máximo de dias es %s', self::MAX_DAYS_TO_FILTER_RANGE));
            }
        }
    }

    private function decodeFilters(string $stringValue): array
    {
        return json_decode(urldecode($stringValue), true);
    }

    private function encodeFilters(array $arrayFilters): string
    {
        return urlencode(json_encode($arrayFilters));
    }

    public function getEncoded(): ?string
    {
        return $this->stringValue;
    }

    public function getEncodedWithDefaultDate(): string
    {
        $dateStart = MyCarbon::now()->startOfMonth()->format(MyCarbon::$date_startYear);
        $dateEnd = MyCarbon::now()->endOfMonth()->format(MyCarbon::$date_startYear);
        $defaultDateFilters = [["field" => $this->filterTimeName, "type" => "like", "value" => ["start" => $dateStart, "end" => $dateEnd]]];
        $filters = $this->isNull() ? $defaultDateFilters : array_merge($this->value, $defaultDateFilters);
        return $this->encodeFilters($filters);
    }

    public function getFilterTime(string $fieldName): ?array
    {
        $isValid = true;
        $filterTime = collect($this->value)->where('field', $fieldName);
        if ($filterTime->isNotEmpty()) {
            $filterTime = $filterTime->first();
            if (!array_key_exists('start', $filterTime['value'])) $isValid = false;
            if (!array_key_exists('end', $filterTime['value'])) $isValid = false;

            if (!$isValid) {
                throw new InvalidValueException(sprintf('Si la clase <%s> contiene un filtro con fecha, se esperan los parámetros start y end.', class_basename(self::class)));
            }
            return $filterTime;
        }
        return null;
    }

    public function isEmptyFilterTime(): bool
    {
        return is_null($this->getFilterTime($this->filterTimeName));
    }

    public function getExportName(string $prefixExportName): string
    {
        $filterTime = $this->getFilterTime($this->filterTimeName);
        $name = "$prefixExportName.xlsx";
        if ($filterTime && $filterTime['value']['start']) {
            $dateStart = MyCarbon::parse($filterTime['value']['start']);
            $dateEnd = MyCarbon::parse($filterTime['value']['end']);
            $monthNameStart = optional($dateStart)->getTranslatedMonthName(); // TODO PHP8 - null safe operator
            $monthNameEnd = optional($dateEnd)->getTranslatedMonthName(); // TODO PHP8 - null safe operator

            $partStart = (!is_null($monthNameStart)) ? $monthNameStart : '';
            $partEnd = (!is_null($monthNameEnd)) ? "_$monthNameEnd" : '';
            $monthsName = ($monthNameStart === $monthNameEnd) ? $monthNameStart : $partStart.$partEnd;

            $name = "{$prefixExportName}_$monthsName.xlsx";
        }
        return $name;
    }

}
