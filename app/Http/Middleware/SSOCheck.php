<?php

namespace App\Http\Middleware;

use App\Domain\Services\OAuthService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SSOCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() && $request->routeIs('login')) {
            /** @var OAuthService $service */
            $service = app(OAuthService::class);
            return $service->authorize($request);
        }
        return $next($request);
    }
}
