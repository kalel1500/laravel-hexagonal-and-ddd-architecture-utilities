<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Contracts\Providers;

interface DynamicEnumProvider
{
    public function getPermittedValues(): array;
}
