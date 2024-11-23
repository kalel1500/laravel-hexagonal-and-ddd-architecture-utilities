<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\DataObjects\Icons;

use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\ContractDataObject;

final class IconDo extends ContractDataObject
{
    protected $name;
    protected $name_short;

    public function __construct(
        string $name,
        string $name_short
    )
    {
        $this->name       = $name;
        $this->name_short = $name_short;
    }

    protected static function createFromArray(array $data): self
    {
        return new self(
            $data['name'] ?? null,
            $data['name_short'] ?? null
        );
    }

    public function name(): string
    {
        return $this->name;
    }

    public function name_short(): string
    {
        return $this->name_short;
    }
}
