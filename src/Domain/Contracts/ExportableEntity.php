<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Contracts;

interface ExportableEntity
{
    static function getExportColumns(): array;
}
