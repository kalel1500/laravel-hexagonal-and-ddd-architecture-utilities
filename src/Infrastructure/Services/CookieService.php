<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

final class CookieService
{
    private $sidebarStatePerPage;
    private $darkModeDefault;

    public function __construct()
    {
        $this->sidebarStatePerPage = config('hexagonal.sidebar.state_per_page');
        $this->darkModeDefault = config('hexagonal.dark_mode_default');
    }

    public static function new(): self
    {
        return new self();
    }

    public function setSidebarStatePerPage(bool $value): self
    {
        $this->sidebarStatePerPage = $value;
        return $this;
    }

    public function setDarkModeDefault(bool $value): self
    {
        $this->darkModeDefault = $value;
        return $this;
    }

    public function create(): \Symfony\Component\HttpFoundation\Cookie
    {
        $preferences = [
            'sidebar_state_per_page' => $this->sidebarStatePerPage,
            'dark_mode_default'      => $this->darkModeDefault,
        ];

        // Crear la cookie usando Cookie::make
        return Cookie::make(
            config('hexagonal.cookie.name'),
            json_encode($preferences),
            config('hexagonal.cookie.duration'),
            '/',
            null,
            true,
            false
        );
    }

    public function createIfNotExist(Request $request): ?\Symfony\Component\HttpFoundation\Cookie
    {
        // Verificar si la cookie ya existe
        if ($request->hasCookie(config('hexagonal.cookie.name'))) {
            return null;
        }

        // Crear la cookie usando Cookie::make
        return $this->create();
    }

}
