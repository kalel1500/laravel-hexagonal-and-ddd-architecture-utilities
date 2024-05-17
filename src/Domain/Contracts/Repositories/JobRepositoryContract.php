<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Contracts\Repositories;

use Thehouseofel\Hexagonal\Domain\Objects\Collections\FailedJobCollection;
use Thehouseofel\Hexagonal\Domain\Objects\Collections\JobCollection;

interface JobRepositoryContract
{
    public function allExceptProcessing(): JobCollection;
    public function deleteAllExceptThoseNotInProcess(): void;
    public function allFailed(): FailedJobCollection;
}
