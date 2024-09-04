<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\BoolVo;

final class ModelBool extends BoolVo
{
    protected const IS_MODEL = true;
}
