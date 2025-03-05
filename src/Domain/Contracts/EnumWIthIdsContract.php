<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Contracts;

interface EnumWIthIdsContract
{
    public static function values(): array;
    public function getId(): int;
    public static function fromId(int $id);
}
