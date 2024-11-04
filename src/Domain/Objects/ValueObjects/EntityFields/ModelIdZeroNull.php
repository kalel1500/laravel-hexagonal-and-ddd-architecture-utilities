<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\Contracts\ContractModelIdZero;

final class ModelIdZeroNull extends ContractModelIdZero
{
    protected const IS_MODEL = true;
}
