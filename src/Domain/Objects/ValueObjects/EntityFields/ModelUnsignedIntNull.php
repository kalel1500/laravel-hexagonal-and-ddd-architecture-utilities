<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\UnsignedIntNullVo;

final class ModelUnsignedIntNull extends UnsignedIntNullVo
{
    protected const IS_MODEL = true;
}
