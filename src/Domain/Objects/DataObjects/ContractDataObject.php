<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\DataObjects;

use Illuminate\Contracts\Support\Jsonable;
use Thehouseofel\Hexagonal\Domain\Contracts\Arrayable;
use Thehouseofel\Hexagonal\Domain\Contracts\BuildArrayable;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\ContractValueObject;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\ArrayVo;

abstract class ContractDataObject implements Arrayable, BuildArrayable, Jsonable
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

    public function toObject()
    {
        return arrayToObject($this->toArrayVisible());
    }

    public function toArrayVo(): ArrayVo
    {
        return ArrayVo::new($this->toArray());
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
     * @param string|null $data
     * @return static|null // TODO PHP8 static return type
     */
    public static function fromJson(?string $data)
    {
        if (is_null($data)) return null;
        return self::fromArray(json_decode($data, true));
    }

    /**
     * @param array $data
     * @return static // TODO PHP8 static return type
     */
    protected static function createFromArray(array $data)
    {
        return new static(...array_values($data));
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public function __toString()
    {
        return $this->toJson();
    }
}
