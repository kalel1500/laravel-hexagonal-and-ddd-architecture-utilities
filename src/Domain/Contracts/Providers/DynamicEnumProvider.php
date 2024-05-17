<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Contracts\Providers;

interface DynamicEnumProvider
{
    public function getPermittedValues(): array;
}
