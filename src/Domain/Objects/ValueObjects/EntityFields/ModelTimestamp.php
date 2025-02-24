<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\TimestampVo;

final class ModelTimestamp extends TimestampVo
{
    protected const IS_MODEL = true;
}
