<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\Collections\Contracts;

use Thehouseofel\Hexagonal\Domain\Exceptions\InvalidValueException;
use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\ContractDataObject;
use TypeError;

abstract class ContractCollectionDo extends ContractCollectionBase
{
    protected const IS_ENTITY = false;

    public function first(): ?ContractDataObject
    {
        return $this->items[0] ?? null;
    }

    static function fromArray(?array $values)
    {
        if (is_null($values)) return null;
        $valueClass = static::VALUE_CLASS;
        $res = [];
        try {
            foreach ($values as $value) {
//            if (!$value instanceof $valueClass) throw new InvalidValueException(sprintf('Los valores del array solo pueden ser de tipo <%s>', $valueClass));
//            $res[] = $value;
                $res[] = ($value instanceof $valueClass) ? $value : $valueClass::fromArray($value);//new $valueClass(...array_values($value));
            }
        } catch (TypeError $exception) {
            throw new InvalidValueException(sprintf('Los valores del array no coinciden con los necesarios para instanciar la clase <%s>. Mira en <fromArray()> del ContractDataObject', $valueClass));
        }
        return new static(...$res); // Los 3 puntos son importantes, ya que los constructores también reciben los parámetros destructurados (...)
    }
}
