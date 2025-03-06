<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\ValueObjects\Parameters;

use Thehouseofel\Kalion\Domain\Objects\ValueObjects\Primitives\Contracts\ContractEnumVo;

final class EnvVo extends ContractEnumVo
{
    const local         = 'local';
    const preproduction = 'preproduction';
    const production    = 'production';
    const testing       = 'testing';

    protected $permittedValues = [
        self::local,
        self::preproduction,
        self::production,
    ];

    public function __construct(string $value)
    {
        if ($value === self::testing) {
            $value = getEnvironmentReal();
        }
        parent::__construct($value);
    }

    public function isLocal(): bool
    {
        return ($this->value === self::local);
    }

    public function isPre(): bool
    {
        return ($this->value === self::preproduction);
    }

    public function isProd(): bool
    {
        return ($this->value === self::production);
    }
}
