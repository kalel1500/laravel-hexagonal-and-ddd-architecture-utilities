<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Thehouseofel\Hexagonal\Infrastructure\Services\CookieService;

final class AddPreferencesCookies
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cookie = CookieService::new()->createIfNotExist($request);

        if (!is_null($cookie)) {
            // Poner la cookie en la cola
            Cookie::queue($cookie);
        }

        return $next($request);
    }
}