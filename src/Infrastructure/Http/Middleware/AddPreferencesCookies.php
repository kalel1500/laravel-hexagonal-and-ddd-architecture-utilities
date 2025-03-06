<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Infrastructure\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Thehouseofel\Kalion\Infrastructure\Services\CookieService;

final class AddPreferencesCookies
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        CookieService::new()
            ->createIfNotExist($request)
            ->queue()
            ->resetAndQueueIfExistInvalid();

        return $next($request);
    }
}
