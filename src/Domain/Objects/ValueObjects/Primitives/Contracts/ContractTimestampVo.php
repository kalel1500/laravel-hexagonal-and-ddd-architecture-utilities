<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\Contracts;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelTimestamp;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelTimestampNull;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\TimestampNullVo;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\TimestampVo;
use Thehouseofel\Hexagonal\Infrastructure\Helpers\MyCarbon;

abstract class ContractTimestampVo extends ContractDateVo
{
    protected const CLASS_REQUIRED = TimestampVo::class;
    protected const CLASS_NULLABLE = TimestampNullVo::class;
    protected const CLASS_MODEL_REQUIRED = ModelTimestamp::class;
    protected const CLASS_MODEL_NULLABLE = ModelTimestampNull::class;

    public function __construct(?string $value, ?array $formats = null)
    {
        $this->formats = [MyCarbon::$datetime_eloquent_timestamps];
        parent::__construct($value, $formats);
    }
}
