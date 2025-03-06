<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields;

use Thehouseofel\Kalion\Domain\Objects\ValueObjects\Primitives\JsonStrictVo;

final class ModelJsonStrictVo extends JsonStrictVo
{
    protected const IS_MODEL = true;
}
