<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Contracts\Repositories;

use Thehouseofel\Hexagonal\Domain\Objects\Collections\StateCollection;
use Thehouseofel\Hexagonal\Domain\Objects\Entities\StateEntity;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Parameters\StatePluckFieldVo;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Parameters\StatePluckKeyVo;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\EnumDynamicVo;

interface StateRepositoryContract
{
    public function all(): StateCollection;
    public function getDictionary(?StatePluckFieldVo $field, ?StatePluckKeyVo $key): array;
    public function getDictionaryByType(EnumDynamicVo $type, ?StatePluckFieldVo $field, ?StatePluckKeyVo $key): array;
    public function getByType(EnumDynamicVo $type): StateCollection;
    public function findByCode(EnumDynamicVo $code): StateEntity;
}
