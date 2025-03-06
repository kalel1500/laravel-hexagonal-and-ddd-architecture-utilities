<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields;

use Thehouseofel\Kalion\Domain\Objects\ValueObjects\Primitives\JsonStrictNullVo;

final class ModelJsonStrictNullVo extends JsonStrictNullVo
{
    protected const IS_MODEL = true;
}
