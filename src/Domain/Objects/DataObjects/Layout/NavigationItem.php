<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\DataObjects\Layout;

use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\ContractDataObject;

abstract class NavigationItem extends ContractDataObject
{
    public $code;
    public $icon;
    public $text;
    public $tooltip;
    public $route_name;
    public $dropdown;
    protected $hasDropdown;

    public function getCode(): string
    {
        return $this->code ?? strToSlug($this->text);
    }

    public function getHref(): string
    {
        return getUrlFromRoute($this->route_name);
    }

    public function hasDropdown(): bool
    {
        return $this->hasDropdown;
    }
}