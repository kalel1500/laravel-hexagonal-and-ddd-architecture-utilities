<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\Contracts;

use Thehouseofel\Hexagonal\Domain\Exceptions\InvalidValueException;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelId;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelIdNull;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\Contracts\ContractIntVo;

abstract class ContractModelId extends ContractIntVo
{
    protected const CLASS_REQUIRED = null;
    protected const CLASS_NULLABLE = null;
    protected const CLASS_MODEL_REQUIRED = ModelId::class;
    protected const CLASS_MODEL_NULLABLE = ModelIdNull::class;

    public function __construct(?int $value)
    {
        parent::__construct($value);
        $this->ensureIsValidValue($value);
    }

    private function ensureIsValidValue(?int $id): void
    {
        if (!is_null($id) && $id < config('hexagonal.minimum_value_for_model_id')) {
            throw new InvalidValueException(sprintf('<%s> does not allow the value <%s>.', class_basename(static::class), $id));
        }
    }

    /**
     * @param int|null $id
     * @return ModelId|ModelIdNull
     */
    public static function from(?int $id)
    {
        return is_null($id) ? static::CLASS_MODEL_NULLABLE::new($id) : static::CLASS_MODEL_REQUIRED::new($id);
    }
}
