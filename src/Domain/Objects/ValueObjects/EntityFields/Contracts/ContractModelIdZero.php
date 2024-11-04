<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\Contracts;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelIdZero;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelIdZeroNull;

abstract class ContractModelIdZero extends ContractModelId
{
    protected const CLASS_MODEL_REQUIRED = ModelIdZero::class;
    protected const CLASS_MODEL_NULLABLE = ModelIdZeroNull::class;

    protected $minimumValueForModelId = 0;
}
