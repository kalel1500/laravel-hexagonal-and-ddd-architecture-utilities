<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\CookiePreferencesDo;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Controller;
use Thehouseofel\Hexagonal\Infrastructure\Services\CookieService;

final class AjaxCookiesController extends Controller
{
    public function update(Request $request): \Illuminate\Http\JsonResponse
    {
        $preferences = CookiePreferencesDo::fromJson(urldecode($request->input('preferences')));

        $cookie = CookieService::new()
            ->setPreferences($preferences)
            ->create();

        // Poner la cookie en la cola
        Cookie::queue($cookie);

        return responseJson(true, 'OK');
    }
}
