<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields;

use Thehouseofel\Kalion\Domain\Objects\ValueObjects\Primitives\DateVo;

final class ModelDate extends DateVo
{
    protected const IS_MODEL = true;
}
