<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Application;

use Thehouseofel\Hexagonal\Domain\Contracts\Repositories\StateRepositoryContract;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Parameters\StatePluckKeyVo;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Parameters\StatePluckFieldVo;
use Thehouseofel\Hexagonal\Domain\Providers\DynamicEnumProviderContract;

final class GetDictionaryStatesByTypeUseCase
{
    private $repository;
    private $dynamicEnumProvider;

    public function __construct(
        StateRepositoryContract $repository,
        DynamicEnumProviderContract $dynamicEnumProvider
    )
    {
        $this->repository = $repository;
        $this->dynamicEnumProvider = $dynamicEnumProvider;
    }

    public function __invoke(string $type, string $field = 'id', string $key = 'code'): array
    {
        $type   = $this->dynamicEnumProvider::newEnum($type);
        $field  = StatePluckFieldVo::new($field);
        $key    = StatePluckKeyVo::new($key);
        return $this->repository->getDictionaryByType($type, $field, $key);
    }
}
