<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\JsonStrictVo;

final class ModelJsonStrictVo extends JsonStrictVo
{
    protected const IS_MODEL = true;
}
