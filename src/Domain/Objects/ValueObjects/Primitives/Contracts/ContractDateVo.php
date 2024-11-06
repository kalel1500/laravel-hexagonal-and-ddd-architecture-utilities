<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\Contracts;

use Carbon\CarbonImmutable;
use Thehouseofel\Hexagonal\Domain\Exceptions\InvalidValueException;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelDate;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelDateNull;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\DateNullVo;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\DateVo;
use Thehouseofel\Hexagonal\Infrastructure\Helpers\MyCarbon;

abstract class ContractDateVo extends ContractStringVo
{
    protected const CLASS_REQUIRED = DateVo::class;
    protected const CLASS_NULLABLE = DateNullVo::class;
    protected const CLASS_MODEL_REQUIRED = ModelDate::class;
    protected const CLASS_MODEL_NULLABLE = ModelDateNull::class;

    protected $format = 'Y-m-d H:i:s';

    public function __construct(?string $value, ?string $format = null)
    {
        $this->format = is_null($format) ? $this->format : $format;
        if (!is_null($value)) {
            $value = MyCarbon::parse($value)->format($this->format);
        }
        parent::__construct($value);
    }

    protected function ensureIsValidValue(?string $value): void
    {
        parent::ensureIsValidValue($value);

        if (!is_null($value) && !MyCarbon::checkFormat($value, $this->format)) {
            throw new InvalidValueException(sprintf('<%s> does not allow this format value <%s>. Needle format: <%s>', class_basename(static::class), $value, $this->format));
        }
    }

    public function formatToSpainDatetime(): ?string
    {
        return $this->isNull() ? null : MyCarbon::parse($this->value)->format(MyCarbon::$datetime_startDay_slash);
    }

    public function carbon(): CarbonImmutable
    {
        return MyCarbon::parse($this->value);
    }
}
