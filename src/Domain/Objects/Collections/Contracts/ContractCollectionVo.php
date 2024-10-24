<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\Collections\Contracts;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\ContractValueObject;

abstract class ContractCollectionVo extends ContractCollectionBase
{
    protected const IS_ENTITY = false;

    public function first(): ?ContractValueObject
    {
        return $this->items[0] ?? null;
        /*return ($this->isEntity())
            ?$this->values[0]->toArray()
            :$this->values[0]->value();*/
    }

    public function firstValue()
    {
        return optional($this->first())->value(); // TODO PHP8 - nullsafe operator
    }

    /**
     * @param array|null $values
     * @param bool $allowNull
     * @param callable|null $valueModifierCallback
     * @return static // TODO PHP8 return static
     */
    static function fromArray(?array $values, bool $allowNull = true, callable $valueModifierCallback = null)
    {
        if (is_null($values)) return null;
        $valueClass = ($allowNull) ? static::VALUE_CLASS_NULL : static::VALUE_CLASS_REQ;
        $res = [];
        foreach ($values as $value) {
            if ($value instanceof $valueClass) {
                $res[] = $value;
            } else {
                if (!is_null($valueModifierCallback)) {
                    $value = $valueModifierCallback($value);
                }
                $res[] = new $valueClass($value);
            }
        }
        $static = new static(...$res); // Los 3 puntos son importantes, ya que los constructores también reciben los parámetros destructurados (...)
        $static->allowNull = $allowNull;
        return $static;
    }
}
