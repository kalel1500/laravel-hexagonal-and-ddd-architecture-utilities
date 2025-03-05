<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\DataObjects;

use Thehouseofel\Kalion\Domain\Objects\ValueObjects\Parameters\ThemeVo;

final class CookiePreferencesDo extends ContractDataObject
{
    protected string  $version;
    protected ThemeVo $theme;
    protected bool    $sidebar_collapsed;
    protected bool    $sidebar_state_per_page;

    public function __construct(
        string  $version,
        ThemeVo $theme,
        bool    $sidebar_collapsed,
        bool    $sidebar_state_per_page
    )
    {
        $this->version                = $version;
        $this->theme                  = $theme;
        $this->sidebar_collapsed      = $sidebar_collapsed;
        $this->sidebar_state_per_page = $sidebar_state_per_page;
    }

    protected static function createFromArray(array $data): self
    {
        return new self(
            $data['version'],
            ThemeVo::new($data['theme'] ?? ThemeVo::system),
            $data['sidebar_collapsed'],
            $data['sidebar_state_per_page']
        );
    }

    public function version(): string
    {
        return $this->version;
    }

    public function theme(): ThemeVo
    {
        return $this->theme;
    }

    public function sidebar_collapsed(): bool
    {
        return $this->sidebar_collapsed;
    }

    public function sidebar_state_per_page(): bool
    {
        return $this->sidebar_state_per_page;
    }

    public function set_version(string $value): void
    {
        $this->version = $value;
    }

    public function set_theme(string $value): void
    {
        $this->theme = $value;
    }

    public function set_sidebar_collapsed(bool $value): void
    {
        $this->sidebar_collapsed = $value;
    }

    public function set_sidebar_state_per_page(bool $value): void
    {
        $this->sidebar_state_per_page = $value;
    }
}
