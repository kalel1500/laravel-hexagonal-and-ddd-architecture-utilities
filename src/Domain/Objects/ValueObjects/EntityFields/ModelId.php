<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\Contracts\ContractModelId;

final class ModelId extends ContractModelId
{
    public function __construct(int $value)
    {
        parent::__construct($value);
    }

    public function value(): int
    {
        return $this->value;
    }
}
