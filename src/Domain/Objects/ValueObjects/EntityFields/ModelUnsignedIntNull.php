<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields;

use Thehouseofel\Kalion\Domain\Objects\ValueObjects\Primitives\UnsignedIntNullVo;

final class ModelUnsignedIntNull extends UnsignedIntNullVo
{
    protected const IS_MODEL = true;
}
