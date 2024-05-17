<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Contracts\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

interface TabulatorRepository
{
    public static function tabulatorFiltering(Builder $query, ?array $filters, array $dontFilter = []) : Builder;
    /**
     * @param Builder|QueryBuilder$query $query
     * @param string|null $field
     * @param string|null $type
     * @param [type] $value
     * @param string|null $fromOtherDBTable
     * @return Builder|QueryBuilder$query
     */
    public static function basicFiltering($query, ?string $field, ?string $type, $value, ?string $fromOtherDBTable = null);
}
