<?php

namespace App\Http\Middleware;

use Closure;

class ContentSecurityPolicy
{
    public function handle($request, Closure $next)
    {
        $policy = "default-src 'self'; script-src 'self' https://www.google-analytics.com 'unsafe-inline'; connect-src 'self' https://www.google-analytics.com; font-src 'self' https://fonts.gstatic.com; style-src 'self' https://fonts.googleapis.com https://fonts.gstatic.com 'unsafe-inline'; img-src 'self' https://fonts.gstatic.com; object-src 'none'; base-uri 'self'; form-action 'self'; frame-ancestors 'none'; block-all-mixed-content; upgrade-insecure-requests";

        $response = $next($request);

        $response->header('Content-Security-Policy', $policy);

        return $response;
    }
}