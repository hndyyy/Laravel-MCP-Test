<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $policy = "default-src 'self'; script-src 'self' 'nonce-' https://ssl.google-analytics.com; style-src 'self' 'unsafe-inline' fonts.googleapis.com; font-src 'self' fonts.gstatic.com data:; connect-src 'self' analytics.google.com; img-src 'self' data:; object-src 'none'; frame-ancestors 'none'; base-uri 'self'; form-action 'self' https://*.payment-gateway.com;";

        $response->headers->set('Content-Security-Policy', $policy);

        return $response;
    }
}