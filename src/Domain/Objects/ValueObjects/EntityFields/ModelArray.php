<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields;

use Thehouseofel\Kalion\Domain\Objects\ValueObjects\Primitives\ArrayVo;

final class ModelArray extends ArrayVo
{
    protected const IS_MODEL = true;
}
