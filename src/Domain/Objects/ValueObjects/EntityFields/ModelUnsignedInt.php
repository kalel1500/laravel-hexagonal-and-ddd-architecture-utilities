<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields;

use Thehouseofel\Kalion\Domain\Objects\ValueObjects\Primitives\UnsignedIntVo;

final class ModelUnsignedInt extends UnsignedIntVo
{
    protected const IS_MODEL = true;
}
