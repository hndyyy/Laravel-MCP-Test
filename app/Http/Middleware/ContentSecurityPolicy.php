<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next)
    {
        $policy = "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.google-analytics.com; font-src 'self' https://fonts.gstatic.com; connect-src 'self' https://www.google-analytics.com; img-src 'self' data:; style-src 'self' 'unsafe-inline'; frame-src 'none'; object-src 'none'; media-src 'self'; manifest-src 'self'; form-action 'self'; frame-ancestors 'self'; base-uri 'self'; report-uri /csp-report";

        $response = $next($request);
        $response->header('Content-Security-Policy', $policy);
        
        return $response;
    }
}