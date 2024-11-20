<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\DataObjects;

final class CookiePreferencesDo extends ContractDataObject
{
    protected $version;
    protected $dark_mode_default;
    protected $sidebar_collapsed_default;
    protected $sidebar_state_per_page;

    public function __construct(
        string $version,
        bool $dark_mode_default,
        bool $sidebar_collapsed_default,
        bool $sidebar_state_per_page
    )
    {
        $this->version                   = $version;
        $this->dark_mode_default         = $dark_mode_default;
        $this->sidebar_collapsed_default = $sidebar_collapsed_default;
        $this->sidebar_state_per_page    = $sidebar_state_per_page;
    }

    protected static function createFromArray(array $data): self
    {
        return new self(
            $data['version'] ?? null,
            $data['dark_mode_default'] ?? null,
            $data['sidebar_collapsed_default'] ?? null,
            $data['sidebar_state_per_page'] ?? null
        );
    }

    public function version(): string
    {
        return $this->version;
    }

    public function dark_mode_default(): bool
    {
        return $this->dark_mode_default;
    }

    public function sidebar_collapsed_default(): bool
    {
        return $this->sidebar_collapsed_default;
    }

    public function sidebar_state_per_page(): bool
    {
        return $this->sidebar_state_per_page;
    }

    public function set_version(string $value): void
    {
        $this->version = $value;
    }

    public function set_dark_mode_default(bool $value): void
    {
        $this->dark_mode_default = $value;
    }

    public function set_sidebar_collapsed_default(bool $value): void
    {
        $this->sidebar_collapsed_default = $value;
    }

    public function set_sidebar_state_per_page(bool $value): void
    {
        $this->sidebar_state_per_page = $value;
    }
}
