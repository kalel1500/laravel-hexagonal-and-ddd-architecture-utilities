<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Parameters;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\Contracts\ContractEnumVo;

final class ThemeVo extends ContractEnumVo
{
    const dark   = 'dark';
    const light  = 'light';
    const system = 'system';

    protected $permittedValues = [
        self::dark,
        self::light,
        self::system,
    ];


    public function isDark(): bool
    {
        return ($this->value === self::dark);
    }

    public function isLight(): bool
    {
        return ($this->value === self::light);
    }

    public function isSystem(): bool
    {
        return ($this->value === self::system);
    }

    public function getDataTheme(): string
    {
        return $this->isSystem() ? '' : $this->value();
    }
}
