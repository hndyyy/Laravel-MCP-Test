<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next)
    {
        $policy = "default-src 'self'; script-src 'self' 'unsafe-eval' 'unsafe-inline' https://cdn.jsdelivr.net https://www.googletagmanager.com https://stats.g.doubleclick.net; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net; connect-src 'self' wss://.example.com; img-src 'self' data: https://www.google-analytics.com https://*.googleapis.com; font-src 'self' https://fonts.gstatic.com data:; child-src 'none'; frame-src 'none'; object-src 'none'; media-src 'none'; form-action 'self'; base-uri 'self';";

        $response = $next($request);
        $response->headers->set('Content-Security-Policy', $policy);

        return $response;
    }
}