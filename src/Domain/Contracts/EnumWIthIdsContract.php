<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Contracts;

interface EnumWIthIdsContract
{
    public static function values(): array;
    public function getId(): int;
}
