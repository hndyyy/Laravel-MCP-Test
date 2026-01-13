<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next)
    {
        $policy = "default-src 'self'; script-src 'self' https://fonts.googleapis.com https://fonts.gstatic.com https://www.google-analytics.com 'unsafe-inline'; style-src 'self' https://fonts.googleapis.com https://fonts.gstatic.com 'unsafe-inline'; font-src 'self' https://fonts.gstatic.com; img-src 'self'; connect-src 'self'; frame-src 'none'; object-src 'none'; media-src 'self'; base-uri 'self';";
        $response = $next($request);
        $response->header('Content-Security-Policy', $policy);
        return $response;
    }
}