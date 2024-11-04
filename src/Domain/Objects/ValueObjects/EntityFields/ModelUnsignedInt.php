<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\UnsignedIntVo;

final class ModelUnsignedInt extends UnsignedIntVo
{
    protected const IS_MODEL = true;
}
