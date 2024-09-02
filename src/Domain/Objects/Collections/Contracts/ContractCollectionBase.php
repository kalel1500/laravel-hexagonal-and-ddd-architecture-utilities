<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\Collections\Contracts;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use Thehouseofel\Hexagonal\Domain\Contracts\Arrayable;
use Thehouseofel\Hexagonal\Domain\Contracts\BuildArrayable;
use Thehouseofel\Hexagonal\Domain\Contracts\Relatable;
use Thehouseofel\Hexagonal\Domain\Exceptions\InvalidValueException;
use Thehouseofel\Hexagonal\Domain\Exceptions\NeverCalledException;
use Thehouseofel\Hexagonal\Domain\Exceptions\RequiredDefinitionException;
use Thehouseofel\Hexagonal\Domain\Objects\Collections\CollectionAny;
use Thehouseofel\Hexagonal\Domain\Objects\Entities\ContractEntity;
use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\ContractDataObject;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\ContractValueObject;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\IntVo;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\JsonVo;

/**
 * @template T of ContractCollectionBase
 */
abstract class ContractCollectionBase implements Countable, ArrayAccess, IteratorAggregate, Arrayable, JsonSerializable
{
    /** @var null|bool */
    protected const IS_ENTITY           = null;
    /** @var null|string */
    protected const ENTITY              = null;
    /** @var null|string */
    protected const VALUE_CLASS         = null;
    /** @var null|string */
    protected const VALUE_CLASS_REQ     = null;
    /** @var null|string */
    protected const VALUE_CLASS_NULL    = null;

    protected $items;
    protected $allowNull = true;

    /**
     * @param array $collResult
     * @return static // TODO PHP8 - static return type
     */
    private function toOriginal(array $collResult)
    {
        if ($this->isInstanceOfRelatable()) return static::fromArray($collResult, $this->with);
        if ($this instanceof ContractCollectionVo) return static::fromArray($collResult, $this->allowNull);
        if ($this instanceof ContractCollectionDo) return static::fromArray($collResult);
        throw new NeverCalledException('La instancia de la colección no extiende de ninguna entidad valida.');
    }

    private function toBase(array $data, string $pluckField = null): CollectionAny
    {
        $with = (!$this->isInstanceOfRelatable()) ? null : getSubWith($this->with, $pluckField);
        return CollectionAny::fromArray($data, $with);
    }

    private function encodeAndDecode(array $array, bool $assoc)
    {
        $res = json_encode($array);
        return json_decode($res, $assoc);
    }

    private function isInstanceOfRelatable(): bool
    {
        return ($this instanceof Relatable);
    }

    protected function ensureIsValid($value): void
    {
        $valueClass = ($this->allowNull) ? static::VALUE_CLASS_NULL : static::VALUE_CLASS_REQ;
        $valueClass = is_null($valueClass) ? static::VALUE_CLASS : $valueClass;
        $class = ($this->isEntity()) ? static::ENTITY : $valueClass;

        if (!$class) {
            throw new RequiredDefinitionException(sprintf('The const <%s> must be declared in <%s>.', 'VALUE_CLASS', class_basename(static::class)));
        }
        if (!(is_string($class) && $class === 'any') && !($value instanceof $class)) {
            $provided = is_object($value) ? get_class($value) : $value;
            throw new InvalidValueException(sprintf('The value of <%s> must be an instance of <%s>. Provided <%s>', class_basename(static::class), $class, $provided));
        }
    }

    protected function isEntity(): ?bool
    {
//        return (method_exists($this->values[0], 'toArray'));
        return static::IS_ENTITY;
    }

    /**
     * @return static // TODO PHP8 - return static
     */
    public static function empty()
    {
        return new static();
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function countInt(): IntVo
    {
        return new IntVo(count($this->items));
    }

    public function offsetExists($offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        $this->items[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->items[$offset]);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function all()
    {
        return $this->items;
    }

    /**
     * @return mixed|null
     */
    public function first()
    {
        return collFirst($this->items);
    }

    /**
     * @return mixed|null
     */
    public function last()
    {
        return collLast($this->items);
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    public function push($value)
    {
        $this->ensureIsValid($value);
        return $this->items[] = $value;
    }

    private static function getItemToArray($item)
    {
        $fromThisClass = (debug_backtrace()[0]['file'] === __FILE__);

        // TODO PHP8 - match
        if ($item instanceof BuildArrayable && $fromThisClass) {
            return $item->toArrayForBuild();
        }
        if ($item instanceof Arrayable) {
            return $item->toArray();
        }
        if ($item instanceof ContractValueObject) {
            return $item->value();
        }
        return $item;
    }

    public function toArray(): array
    {
        $result = [];
        foreach ($this->items as $key => $item) {
            $item = self::getItemToArray($item);
            $result[$key] = $item;
        }
        return $result;
    }

    public function toClearedArray(): array
    {
        return $this->encodeAndDecode($this->toArray(), true);
    }

    /**
     * @return object|array // TODO PHP8 - Union types
     */
    public function toClearedObject()
    {
        return $this->encodeAndDecode($this->toArray(), false);
    }

    public function toCollect()
    {
        return myCollect($this->toArray());
    }

    /**
     * @param class-string<T> $collectionClass
     * @return T
     */
    public function toCollection(string $collectionClass)
    {
        if (is_subclass_of($collectionClass, Relatable::class)) {
            return $collectionClass::fromArray($this->toArray(), $this->with);
        }
        return $collectionClass::fromArray($this->toArray());
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public function toJsonVo(): JsonVo
    {
        return new JsonVo($this->toArray());
    }

    public function pluck(string $field, string $key = null): CollectionAny
    {
        $getItemValue = function($collectionItem, string $pluckField) {
            if (is_array($collectionItem)) {
                return $collectionItem[strToSnake($pluckField)];
            }
            if (!is_object($collectionItem)) {
                return null;
            }
            /*if (($value instanceof ContractDataObject)) {
                $publicProperties = get_class_vars(get_class($value));
                if (array_key_exists($string, $publicProperties)) {
                    return $value->$string;
                }
                if (str_contains($string, '()')) {
                    $sub = substr($string, 0, -2);
                    $valueString =  $value->$sub();
                } else {
                    return null;
                }
            } else {
                $valueString = $value->$string();
            }*/

            $valueField = ($collectionItem instanceof ContractDataObject)
                ? (str_contains($pluckField, '()') ? $collectionItem->{substr($pluckField, 0, -2)}() : $collectionItem->toArrayWithAll()[$pluckField])
                : (method_exists($collectionItem, $pluckField) ? $collectionItem->$pluckField() : $collectionItem->$pluckField);

            return $valueField;
//            throw new NeverCalledException(sprintf('El valor de "$value" no se ha contemplado en la función "pluck" de la clase <%s>', static::class));
        };
        $clearItemValue = function($item) {
            // TODO PHP8 - match
            if ($item instanceof Arrayable) {
                return $item->toArray();
            }
            if ($item instanceof ContractValueObject) {
                return $item->value();
            }
            return $item;
        };

        $result = [];
        foreach ($this->items as $item) {
            $fieldValue = $getItemValue($item, $field);
            $fieldValue = $clearItemValue($fieldValue);

            if (is_null($key)) {
                $result[] = $fieldValue;
            } else {
                $keyValue = $getItemValue($item, $key);
                $keyValue = $clearItemValue($keyValue);
                $result[$keyValue] = $fieldValue;
            }
        }

//        return (new CollectionAnyVo($result))->whereNotNull();
        return $this->toBase($result, $field);
    }

    /**
     * @param string $field
     * @param class-string<T> $to
     * @return T
     */
    public function pluckTo(string $field, string $to)
    {
        return $this->pluck($field)->toCollection($to);
    }

    public function collapse(): CollectionAny
    {
        $results = [];
        foreach ($this->items as $item) {
            if ($item instanceof Arrayable) {
                $item = $item->toArray();
            }
            if (is_null($item)) {
                continue;
            }
            /*if (!is_array($item)) {
                continue;
            }*/
            $results[] = (!is_array($item) || !arrAllValuesAreArray($item)) ? [$item] : $item;
        }

        return $this->toBase(array_merge([], ...$results));
    }

    /**
     * @param $callback
     * @param $options
     * @param $descending
     * @return static
     */
    public function sortBy($callback, $options = SORT_REGULAR, $descending = false)
    {
        $collResult = collSortBy($this->toArray(), $callback, $options, $descending)->values();
        return $this->toOriginal($collResult->toArray());
    }

    public function sortByDesc($callback, $options = SORT_REGULAR)
    {
        return $this->sortBy($callback, $options, true);
    }

    public function where($key, $operator = null, $value = null)
    {
        $collResult = collWhere($this->toArray(), ...func_get_args())->values();
        return $this->toOriginal($collResult->toArray());
    }

    public function whereIn($key, $values, $strict = false)
    {
        $collResult = collWhereIn($this->toArray(), $key, $values, $strict)->values();
        return $this->toOriginal($collResult->toArray());
    }

    public function contains($key, $operator = null, $value = null): bool
    {
        $array = (is_callable($key)) ? $this->toClearedObject() : $this->toArray();
        return collContains($array, ...func_get_args());
    }

    public function whereNotNull($key = null)
    {
        return $this->where($key, '!==', null);
    }

    public function values()
    {
        return $this->toOriginal(array_values($this->toArray()));
    }

    public function unique($key = null, $strict = false)
    {
        $collResult = collUnique($this->toArray(), $key, $strict)->values();
        return $this->toOriginal($collResult->toArray());
    }

    public function filter(callable $callback = null)
    {
        $collResult = collFilter($this->toArray(), $callback)->values();
        return $this->toOriginal($collResult->toArray());
    }

    public function implode(string $value): string
    {
        return implode($value, $this->toArray());
    }

    public function sort($callback = null)
    {
        $collResult = collSort($this->toArray(), $callback)->values();
        return $this->toOriginal($collResult->toArray());
    }

    public function sortDesc($options = SORT_REGULAR)
    {
        $collResult = collSortDesc($this->toArray(), $options)->values();
        return $this->toOriginal($collResult->toArray());
    }

    public function groupBy($groupBy, $preserveKeys = false): CollectionAny
    {
        $collResult = collGroupBy($this->toArray(), $groupBy, $preserveKeys);
        if ($collResult->keys()->some('')) throw new RequiredDefinitionException('La key que has indicado no se encuentra en el array del objeto');
        $new = $collResult->map(function ($group) {
            return $this->toOriginal($group->toArray());
            /*$group->map(function ($item) {
                dd($item);
                return $this->toOriginal($item->toArray());
            });*/
        });
//        dd($new);
        return $this->toBase($new->toArray());
    }

    public function select($keys)
    {
        $keys = is_array($keys) ? $keys : func_get_args();
        $collResult = collSelect($this->toArray(), $keys)->values();
        return $this->toOriginal($collResult->toArray());
    }

    public function diff(ContractCollectionBase $items, string $field = null)
    {
        if (!is_null($field)) {
            $diff = collect();
            $dictionary = $items->pluck($field);
            foreach ($this->toArray() as $item) {
                if (!$dictionary->contains($item[$field])) {
                    $diff->add($item);
                }
            }
        } else {
            $array1 = array_map('json_encode', $this->toArray());
            $array2 = array_map('json_encode', $items->toArray());

            $result = array_diff($array1, $array2);
            $result = array_map(function($item) { return json_decode($item, true); }, $result);

            $diff = collect($result)->values();
        }

        return $this->toOriginal($diff->toArray());
    }

    /**
     * @param ContractCollectionBase|array $items
     * @return static // TODO PHP8 - static return type
     */
    public function diffKeys($items)
    {
        $array1 = $this->toArray();
        $array2 = $this->getArrayableItems($items);
        $result = array_diff_key($array1, $array2);
        $diff = collect($result);
        return $this->toOriginal($diff->toArray());
    }

    public function flip()
    {
        $result = array_flip($this->toArray());
        $diff = collect($result);
        return $this->toOriginal($diff->toArray());
    }

    public function map(callable $callback)
    {
        $keys = array_keys($this->items);
        $items = array_map($callback, $this->items, $keys);
        $result = collect(array_combine($keys, $items));
        $resultArray = $result->toArray();
        return $result->contains(function ($item) {
            return ! $item instanceof ContractEntity;
        }) ? $this->toBase($resultArray) : $this->toOriginal($resultArray);
    }

    public function flatten(int $depth = INF)
    {
        $collResult = collFlatten($this->toArray(), $depth)->values();
        return $this->toOriginal($collResult->toArray());
    }

    public function take(int $limit)
    {
        $collResult = collTake($this->toArray(), $limit)->values();
        return $this->toOriginal($collResult->toArray());
    }

    /**
     * @return mixed|null
     */
    public function firstWhere($key, $operator = null, $value = null)
    {
        return $this->where(...func_get_args())->first();
    }

    protected function getArrayableItems($items): array
    {
        if (is_array($items)) {
            return $items;
        } elseif ($items instanceof ContractCollectionBase) {
            return $items->toArray();
        }

        return (array) $items;
    }
}
