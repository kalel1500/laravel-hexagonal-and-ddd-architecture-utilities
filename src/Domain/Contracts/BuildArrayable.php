<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Contracts;

interface BuildArrayable
{
    public function toArrayForBuild(): array;
}
