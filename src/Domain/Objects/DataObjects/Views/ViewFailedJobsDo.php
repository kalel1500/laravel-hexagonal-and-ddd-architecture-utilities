<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\DataObjects\Views;

use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\ContractDataObject;
use Thehouseofel\Hexagonal\Domain\Objects\Entities\Collections\FailedJobCollection;

final class ViewFailedJobsDo extends ContractDataObject
{
    private $jobs;

    public function __construct(FailedJobCollection $jobs)
    {
        $this->jobs = $jobs;
    }

    public function jobs(): FailedJobCollection
    {
        return $this->jobs;
    }
}
