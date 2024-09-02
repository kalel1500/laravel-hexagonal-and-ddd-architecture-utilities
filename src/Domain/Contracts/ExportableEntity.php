<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Contracts;

interface ExportableEntity
{
    static function getExportColumns(): array;
}
