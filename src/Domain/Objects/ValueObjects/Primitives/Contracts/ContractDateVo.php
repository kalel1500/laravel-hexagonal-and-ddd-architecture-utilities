<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\Contracts;

use Thehouseofel\Hexagonal\Domain\Exceptions\InvalidValueException;
use Thehouseofel\Hexagonal\Infrastructure\Helpers\MyCarbon;

abstract class ContractDateVo extends ContractStringVo
{
    private $format;

    public function __construct(?string $value, bool $isDatetime = true)
    {
        $this->format = $isDatetime ? MyCarbon::$datetime_startYear : MyCarbon::$date_startYear;
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
}
