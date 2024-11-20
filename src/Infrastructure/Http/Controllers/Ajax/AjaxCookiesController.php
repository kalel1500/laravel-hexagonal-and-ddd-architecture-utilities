<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Thehouseofel\Hexagonal\Infrastructure\Http\Controllers\Controller;
use Thehouseofel\Hexagonal\Infrastructure\Services\CookieService;

final class AjaxCookiesController extends Controller
{
    public function update(Request $request): \Illuminate\Http\JsonResponse
    {
        $preferences = $request->input('preferences');
        $preferences = json_decode(urldecode($preferences), true);

        $cookie = CookieService::new()
            ->setDarkModeDefault($preferences['dark_mode_default'])
            ->setSidebarStatePerPage($preferences['sidebar_state_per_page'])
            ->create();

        // Poner la cookie en la cola
        Cookie::queue($cookie);

        return responseJson(true, 'OK');
    }
}
