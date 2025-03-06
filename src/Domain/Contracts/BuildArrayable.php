<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Contracts;

interface BuildArrayable
{
    public function toArrayForBuild(): array;
}
