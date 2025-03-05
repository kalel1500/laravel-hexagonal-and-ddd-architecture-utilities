<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\ValueObjects\Parameters;

use Thehouseofel\Kalion\Domain\Objects\ValueObjects\Primitives\Contracts\ContractEnumVo;

final class StatePluckKeyVo extends ContractEnumVo
{
    const code = 'code';
    const id = 'id';

    protected $permittedValues = [
        self::code,
        self::id,
    ];

    public function __construct(string $value)
    {
        parent::__construct($value);
    }

    public static function code(): self
    {
        return new self(self::code);
    }

    public static function id(): self
    {
        return new self(self::id);
    }
}
