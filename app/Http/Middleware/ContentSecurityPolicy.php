<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next)
    {
        $nonce = bin2hex(random_bytes(16));
        $request->attributes->set('csp_nonce', $nonce);

        $policy = "default-src 'self' 'strict-dynamic' https: http:; " .
                  "script-src 'self' 'unsafe-inline' 'nonce-" . $nonce . "' https://fonts.googleapis.com; " .
                  "connect-src 'self' http://127.0.0.1:8000 https://127.0.0.1:8000 https://127.0.0.1; " .
                  "img-src 'self' data: https://fonts.gstatic.com; " .
                  "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; " .
                  "font-src 'self' https://fonts.gstatic.com; " .
                  "form-action 'self'; " .
                  "frame-ancestors 'none'; " .
                  "base-uri 'self'; " .
                  "report-uri /csp-report-endpoint/;";

        $request->headers->set('Content-Security-Policy', $policy);

        return $next($request);
    }
}