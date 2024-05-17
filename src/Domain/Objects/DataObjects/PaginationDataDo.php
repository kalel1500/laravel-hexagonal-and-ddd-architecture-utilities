<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\DataObjects;

final class PaginationDataDo extends ContractDataObject
{
    private $total;
    private $lastPage;
    private $perPage;
    private $currentPage;
    private $path;
    private $pageName;
    private $htmlLinks;

    public function __construct(
        int $total,
        int $lastPage,
        int $perPage,
        int $currentPage,
        ?string $path,
        string $pageName,
        string $htmlLinks
    ) {
        $this->total = $total;
        $this->lastPage = $lastPage;
        $this->perPage = $perPage;
        $this->currentPage = $currentPage;
        $this->path = $path;
        $this->pageName = $pageName;
        $this->htmlLinks = $htmlLinks;
    }

    public function total(): int
    {
        return $this->total;
    }

    public function lastPage(): int
    {
        return $this->lastPage;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }

    public function currentPage(): int
    {
        return $this->currentPage;
    }

    public function path(): ?string
    {
        return $this->path;
    }

    public function pageName(): string
    {
        return $this->pageName;
    }

    public function htmlLinks(): string
    {
        return $this->htmlLinks;
    }
}
