<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields;

use Thehouseofel\Kalion\Domain\Objects\ValueObjects\Primitives\StringVo;

final class ModelString extends StringVo
{
    protected const IS_MODEL = true;
}
