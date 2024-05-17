<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\Contracts;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\ContractValueObject;

abstract class ContractArrayVo extends ContractValueObject implements ArrayAccess, IteratorAggregate
{
    public function __construct(?array $value)
    {
        $this->value = $value;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->value);
    }

    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->value);
    }

    public function offsetGet($offset)
    {
        return $this->value[$offset];
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->value[] = $value;
        } else {
            $this->value[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->value[$offset]);
    }

    public function offsetUnsetLike(string $key)
    {
//        $pattern = "/^$key/";
//        $keysToUnset = array_values(preg_grep($pattern, array_keys($this->value)));
        $keysToUnset = array_keys(array_filter($this->value, function ($item) use ($key) { return (strpos($item, $key) !== false); }, ARRAY_FILTER_USE_KEY));
        foreach ($keysToUnset as $key) {
            unset($this->value[$key]);
        }
    }

    public function value(): ?array
    {
        return $this->value;
    }

    public function isEmpty(): bool
    {
        return empty($this->value);
    }

    public function count(): ?int
    {
        return ($this->isNull()) ? null : count($this->value);
    }

    /**
     * @param string|array $key // TODO PHP8 - Union types
     * @return bool
     */
    public function has($key): bool
    {
        $keys = is_array($key) ? $key : func_get_args();
        foreach ($keys as $value) {
            if (! $this->offsetExists($value)) {
                return false;
            }
        }
        return true;
    }

    public function get(string $key, $default = null)
    {
        if ($this->offsetExists($key)) {
            return $this->value[$key];
        }

        return $default;
    }

    /**
     * @param  mixed  $key
     * @param  mixed  $value
     * @return $this
     */
    public function put($key, $value)
    {
        $this->offsetSet($key, $value);

        return $this;
    }

    /**
     * @param  string|array $keys // TODO PHP8 - Union types
     * @return $this
     */
    public function forget($keys)
    {
        foreach ((array) $keys as $key) {
            $this->offsetUnset($key);
        }

        return $this;
    }

    /**
     * @param  string|array $keys // TODO PHP8 - Union types
     * @return $this
     */
    public function forgetLike($keys)
    {
        foreach ((array) $keys as $key) {
            $this->offsetUnsetLike($key);
        }

        return $this;
    }

    /**
     * @param ...$values
     * @return $this
     */
    public function push(...$values)
    {
        foreach ($values as $value) {
            $this->value[] = $value;
        }

        return $this;
    }

    public function toJson(): ?string
    {
        return ($this->isEmpty()) ? null : json_encode($this->value);
    }

}
