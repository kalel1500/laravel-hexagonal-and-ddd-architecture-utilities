<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\Contracts;

use Thehouseofel\Hexagonal\Domain\Exceptions\InvalidValueException;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\Contracts\ContractIntVo;

abstract class ContractModelId extends ContractIntVo
{
    public function __construct(?int $value)
    {
        parent::__construct($value);
        $this->ensureIsValidValue($value);
    }

    private function ensureIsValidValue(?int $id): void
    {
        if (!is_null($id) && $id < 1) {
            throw new InvalidValueException(sprintf('<%s> does not allow the value <%s>.', class_basename(static::class), $id));
        }
    }
}
