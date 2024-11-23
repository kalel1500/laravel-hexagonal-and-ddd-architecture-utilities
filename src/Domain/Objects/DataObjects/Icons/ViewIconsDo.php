<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\DataObjects\Icons;

use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\ContractDataObject;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\BoolVo;

final class ViewIconsDo extends ContractDataObject
{
    protected $icons;
    protected $show_name_short;

    public function __construct(
        IconCollection $icons,
        BoolVo         $show_name_short
    )
    {
        $this->icons           = $icons;
        $this->show_name_short = $show_name_short;
    }

    protected static function createFromArray(array $data): self
    {
        return new self(
            IconCollection::fromArray($data['icons'] ?? null),
            BoolVo::new($data['show_name_short'] ?? null)
        );
    }

    public function icons(): IconCollection
    {
        return $this->icons;
    }

    public function show_name_short(): BoolVo
    {
        return $this->show_name_short;
    }
}
