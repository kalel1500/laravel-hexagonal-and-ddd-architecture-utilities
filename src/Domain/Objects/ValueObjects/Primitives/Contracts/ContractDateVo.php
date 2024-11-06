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

    protected $allowZeros = false;
    protected $formats    = ['Y-m-d H:i:s'];

    public function __construct(?string $value, ?array $formats = null)
    {
        $this->formats = is_null($formats) ? $this->formats : $formats;
        parent::__construct($value);
    }

    protected function ensureIsValidValue(?string $value): void
    {
        parent::ensureIsValidValue($value);

        if (!is_null($value) && !MyCarbon::checkFormats($value, $this->formats, $this->allowZeros)) {
            throw new InvalidValueException(sprintf('<%s> does not allow this format value <%s>. Needle formats: <%s>', class_basename(static::class), $value, implode(', ', $this->formats)));
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
