<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Application;

use Thehouseofel\Hexagonal\Domain\Contracts\Repositories\StateRepositoryContract;
use Thehouseofel\Hexagonal\Domain\Objects\Entities\StateEntity;
use Thehouseofel\Hexagonal\Domain\Providers\DynamicEnumProviderContract;

final class FindStateByCodeUseCase
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

    public function __invoke(string $code): StateEntity
    {
        return $this->repository->findByCode($this->dynamicEnumProvider::newEnum($code));
    }
}
