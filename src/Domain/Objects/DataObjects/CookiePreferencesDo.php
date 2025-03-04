<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\DataObjects;

final class CookiePreferencesDo extends ContractDataObject
{
    protected $version;
    protected $theme;
    protected $sidebar_collapsed;
    protected $sidebar_state_per_page;

    public function __construct(
        string $version,
        ?string $theme,
        bool   $sidebar_collapsed,
        bool   $sidebar_state_per_page
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
            $data['version'] ?? null,
            $data['theme'] ?? null,
            $data['sidebar_collapsed'] ?? null,
            $data['sidebar_state_per_page'] ?? null
        );
    }

    public function version(): string
    {
        return $this->version;
    }

    public function theme(): ?string
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


    public function isDarkMode(): bool
    {
        return $this->theme === 'dark';
    }
}
