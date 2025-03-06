<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields;

use Thehouseofel\Kalion\Domain\Objects\ValueObjects\Primitives\ArrayNullVo;

final class ModelArrayNull extends ArrayNullVo
{
    protected const IS_MODEL = true;
}
