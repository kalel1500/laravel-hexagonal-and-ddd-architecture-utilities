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
    protected $valueCarbon;

    public function __construct(?string $value, ?array $formats = null)
    {
        $this->formats = is_null($formats) ? $this->formats : $formats;
        parent::__construct($value);
    }

    /**
     * @return static // TODO PHP8 static return type
     */
    public static function new($value, ?array $formats = null)
    {
        return new static($value, $formats);
    }

    /**
     * @return static // TODO PHP8 static return type
     */
    public static function from($value)
    {
        $formatted = MyCarbon::parse($value)
            ->setTimezone(config('app.timezone'))
            ->format('Y-m-d H:i:s');
        return static::new($formatted);
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
        return $this->valueCarbon ?? MyCarbon::parse($this->value)->setTimezone(config('app.timezone'));
    }
}
