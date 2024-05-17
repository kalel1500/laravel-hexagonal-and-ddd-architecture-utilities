<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Application;

use Thehouseofel\Hexagonal\Domain\Contracts\Repositories\JobRepositoryContract;
use Thehouseofel\Hexagonal\Domain\Objects\Collections\FailedJobCollection;

final class GetAllFailedJobsUseCase
{
    private $repository;

    public function __construct(JobRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(): FailedJobCollection
    {
        return $this->repository->allFailed();
    }
}
