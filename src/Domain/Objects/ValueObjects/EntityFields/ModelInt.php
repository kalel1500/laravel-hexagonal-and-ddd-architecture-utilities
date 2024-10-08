<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\IntVo;

final class ModelInt extends IntVo
{
    protected const IS_MODEL = true;
}
