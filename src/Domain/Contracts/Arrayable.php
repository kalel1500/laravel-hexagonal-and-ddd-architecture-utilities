<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Contracts;

interface Arrayable
{
    public function toArray(): array;
}
