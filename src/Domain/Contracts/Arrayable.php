<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Contracts;

interface Arrayable
{
    public function toArray(): array;
}
