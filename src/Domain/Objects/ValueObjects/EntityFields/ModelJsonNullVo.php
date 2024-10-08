<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\JsonNullVo;

final class ModelJsonNullVo extends JsonNullVo
{
    protected const IS_MODEL = true;
}
