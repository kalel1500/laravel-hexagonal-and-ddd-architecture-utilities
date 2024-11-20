<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\CookiePreferencesDo;

final class CookieService
{
    private $cookieName;
    private $preferences;

    public function __construct()
    {
        $this->cookieName  = config('hexagonal.cookie.name');
        $this->preferences = new CookiePreferencesDo(
            config('hexagonal.dark_mode_default'),
            config('hexagonal.sidebar_collapsed_default'),
            config('hexagonal.sidebar_state_per_page')
        );
    }

    public function preferences(): CookiePreferencesDo
    {
        return $this->preferences;
    }

    public function setPreferences(CookiePreferencesDo $preferences): self
    {
        $this->preferences = $preferences;
        return $this;
    }

    public static function new(): self
    {
        return new self();
    }

    public function create(): \Symfony\Component\HttpFoundation\Cookie
    {
        // Crear la cookie usando Cookie::make
        return Cookie::make(
            $this->cookieName,
            $this->preferences->__toString(),
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
        if ($request->hasCookie($this->cookieName)) {
            return null;
        }

        // Crear la cookie usando Cookie::make
        return $this->create();
    }
}
