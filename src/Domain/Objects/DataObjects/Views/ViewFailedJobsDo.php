<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\DataObjects\Views;

use Thehouseofel\Hexagonal\Domain\Objects\Collections\FailedJobCollection;
use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\ContractDataObject;

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
