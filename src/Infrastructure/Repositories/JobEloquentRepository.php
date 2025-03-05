<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Infrastructure\Repositories;

use Thehouseofel\Kalion\Domain\Contracts\Repositories\JobRepositoryContract;
use Thehouseofel\Kalion\Domain\Objects\Entities\Collections\FailedJobCollection;
use Thehouseofel\Kalion\Domain\Objects\Entities\Collections\JobCollection;
use Thehouseofel\Kalion\Infrastructure\Models\FailedJob;
use Thehouseofel\Kalion\Infrastructure\Models\Jobs;

class JobEloquentRepository implements JobRepositoryContract
{
    private $eloquentModel;
    private $failedJobseloquentModel;

    public function __construct()
    {
        $this->eloquentModel = new Jobs();
        $this->failedJobseloquentModel = new FailedJob();
    }

    public function allExceptProcessing(): JobCollection
    {
        $eloquentResult = $this->eloquentModel->newQuery()->whereNull('reserved_at')->get();
        return JobCollection::fromArray($eloquentResult->toArray());
    }

    public function deleteAllExceptThoseNotInProcess(): void
    {
        // $first = $this->eloquentModel->query()->first();
        // $this->eloquentModel->query()->where('id', '!=', optional($first)->id)->delete();
        $this->eloquentModel->query()->whereNull('reserved_at')->delete();
    }

    public function allFailed(): FailedJobCollection
    {
        $eloquentResult = $this->failedJobseloquentModel->newQuery()->orderBy('failed_at', 'desc')->get();
        return FailedJobCollection::fromArray($eloquentResult->toArray());
    }
}
