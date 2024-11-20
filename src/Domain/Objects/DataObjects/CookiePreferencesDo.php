<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\DataObjects;

final class CookiePreferencesDo extends ContractDataObject
{
    protected $dark_mode_default;
    protected $sidebar_state_per_page;

    public function __construct(
        bool $dark_mode_default,
        bool $sidebar_state_per_page
    )
    {
        $this->dark_mode_default      = $dark_mode_default;
        $this->sidebar_state_per_page = $sidebar_state_per_page;
    }

    protected static function createFromArray(array $data): self
    {
        return new self(
            $data['dark_mode_default'] ?? null,
            $data['sidebar_state_per_page'] ?? null
        );
    }

    public function dark_mode_default(): bool
    {
        return $this->dark_mode_default;
    }

    public function sidebar_state_per_page(): bool
    {
        return $this->sidebar_state_per_page;
    }

    public function set_dark_mode_default(bool $value): void
    {
        $this->dark_mode_default = $value;
    }

    public function set_sidebar_state_per_page(bool $value): void
    {
        $this->sidebar_state_per_page = $value;
    }
}
