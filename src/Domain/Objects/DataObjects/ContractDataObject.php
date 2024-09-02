<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\DataObjects;

use Thehouseofel\Hexagonal\Domain\Contracts\Arrayable;
use Thehouseofel\Hexagonal\Domain\Contracts\BuildArrayable;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\ContractValueObject;

abstract class ContractDataObject implements Arrayable, BuildArrayable
{
    private function getValue($value)
    {
        return ($value instanceof ContractValueObject) ? $value->value() : $value;
    }

    private function toArrayVisible(): array
    {
        $coll = [];
        foreach ($this as $clave => $valor) {
            $coll[$clave] = $this->getValue($valor);
        }
        return objectToArray($coll);
    }

    public function toArray(): array
    {
        return $this->toArrayVisible();
    }

    public function toArrayForBuild(): array
    {
        return $this->toArrayVisible();
    }

    public function toArrayForJs(): array
    {
        return $this->toArrayVisible();
    }

    public function toObject()
    {
        return arrayToObject($this->toArrayVisible());
    }

    /**
     * @param array|null $data
     * @return static|null // TODO PHP8 static return type
     */
    public static function fromArray(?array $data)
    {
        if (is_null($data)) return null;
        return static::createFromArray($data);
    }

    /**
     * @param array $data
     * @return static // TODO PHP8 static return type
     */
    protected static function createFromArray(array $data)
    {
        return new static(...array_values($data));
    }
}
