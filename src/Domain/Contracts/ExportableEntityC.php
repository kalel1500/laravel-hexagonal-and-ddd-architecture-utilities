<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Contracts;

interface ExportableEntityC
{
    static function getExportColumns(): array;
}
