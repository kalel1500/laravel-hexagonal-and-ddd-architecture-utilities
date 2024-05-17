<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\Contracts\ContractModelId;

class ModelIdNull extends ContractModelId
{
    public function toModelId(): ModelId
    {
        return new ModelId($this->value());
    }
}
