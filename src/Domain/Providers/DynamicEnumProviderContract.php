<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Providers;

use Thehouseofel\Hexagonal\Domain\Contracts\Providers\DynamicEnumProvider;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\EnumDynamicVo;

abstract class DynamicEnumProviderContract implements DynamicEnumProvider
{
    protected $permittedValues = null;

    public function getPermittedValues(): array
    {
        return $this->permittedValues;
    }

    public static function newEnum(string $value): EnumDynamicVo
    {
        return EnumDynamicVo::new($value, new static());
    }
}
