<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\CookiePreferencesDo;

final class CookieService
{
    private $preferences;

    public function __construct()
    {
        $this->preferences = new CookiePreferencesDo(
            config('hexagonal.dark_mode_default'),
            config('hexagonal.sidebar.state_per_page')
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
            config('hexagonal.cookie.name'),
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
        if ($request->hasCookie(config('hexagonal.cookie.name'))) {
            return null;
        }

        // Crear la cookie usando Cookie::make
        return $this->create();
    }

}
