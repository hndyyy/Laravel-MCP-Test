<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next)
    {
        $nonce = base64_encode(random_bytes(16));
        $request->attributes->set('csp_nonce', $nonce);

        $policy = "default-src 'self'; script-src 'self' 'nonce-".htmlspecialchars($nonce, ENT_QUOTES, 'UTF-8')."' http://localhost:5173 https://*.google-analytics.com https://*.googletagmanager.com https://fonts.googleapis.com https://fonts.gstatic.com; connect-src 'self'; style-src 'self' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https://fonts.gstatic.com; object-src 'none'; base-uri 'self'; form-action 'self'; block-all-mixed-content;";

        $response = $next($request);
        $response->headers->set('Content-Security-Policy', $policy);

        return $response;
    }
}