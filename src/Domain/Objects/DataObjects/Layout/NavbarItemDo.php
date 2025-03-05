<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\DataObjects\Layout;

use Thehouseofel\Kalion\Domain\Objects\DataObjects\Layout\Contracts\NavigationItem;

final class NavbarItemDo extends NavigationItem
{
    public $code;
    public $icon;
    public $text;
    public $time;
    public $tooltip;
    public $route_name;
    public $is_post;
    public $is_theme_toggle;
    public $is_user;
    public $is_separator;
    public $dropdown;

    public function __construct(
        ?string             $code,
        ?string             $icon,
        ?string             $text,
        ?string             $time,
        ?string             $tooltip,
        ?string             $route_name,
        ?bool               $is_post,
        ?bool               $is_theme_toggle,
        ?bool               $is_user,
        ?bool               $is_separator,
        ?NavbarDropdownDo   $dropdown
    )
    {
        $this->code             = $code;
        $this->icon             = $icon;
        $this->text             = $text;
        $this->time             = $time;
        $this->tooltip          = $tooltip;
        $this->route_name       = $route_name;
        $this->is_post          = $is_post;
        $this->is_theme_toggle  = $is_theme_toggle;
        $this->is_user          = $is_user;
        $this->is_separator     = $is_separator;
        $this->dropdown         = $dropdown;
        $this->hasDropdown      = !is_null($dropdown);
    }

    protected static function createFromArray(array $data): self
    {
        return new self(
            $data['code'] ?? null,
            $data['icon'] ?? null,
            $data['text'] ?? null,
            $data['time'] ?? null,
            $data['tooltip'] ?? null,
            $data['route_name'] ?? null,
                $data['is_post'] ?? null,
            $data['is_theme_toggle'] ?? null,
            $data['is_user'] ?? null,
            $data['is_separator'] ?? null,
            NavbarDropdownDo::fromArray($data['dropdown'] ?? null)
        );
    }
}
