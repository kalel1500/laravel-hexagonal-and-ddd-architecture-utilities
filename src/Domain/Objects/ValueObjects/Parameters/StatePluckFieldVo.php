<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Parameters;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\Contracts\ContractEnumVo;

final class StatePluckFieldVo extends ContractEnumVo
{
    const id = 'id';
    const name = 'name';

    protected $permittedValues = [
        self::id,
        self::name,
    ];

    public function __construct(string $value)
    {
        parent::__construct($value);
    }

    public static function id(): self
    {
        return new self(self::id);
    }

    public static function name(): self
    {
        return new self(self::name);
    }
}
