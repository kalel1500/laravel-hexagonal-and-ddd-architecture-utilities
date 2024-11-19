<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class AddPreferencesCookies
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        $cookieName = config('hexagonal.cookie.name');
        if (!$request->hasCookie($cookieName)) {
            $preferences = [
                'sidebar_state_per_page' => config('hexagonal.sidebar.state_per_page'),
                'dark_mode_default'      => config('hexagonal.dark_mode_default'),
            ];

            $response->cookie(
                $cookieName,
                json_encode($preferences),
                config('hexagonal.cookie.duration'),
                '/',
                null,
                false, // HTTPS no requerido
                false // HttpOnly desactivado
            );
        }

        return $response;
    }
}