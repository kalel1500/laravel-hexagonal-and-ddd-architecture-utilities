<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\ArrayVo;

final class ModelArray extends ArrayVo
{
    protected const IS_MODEL = true;
}
