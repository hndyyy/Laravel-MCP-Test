<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next)
    {
        $nonce = base64_encode(random_bytes(16));
        $request->attributes->set('csp_nonce', $nonce);

        $policy = "default-src 'self'; script-src 'self' 'nonce-{$nonce}' fonts.gstatic.com; script-src-elem 'self' 'nonce-{$nonce}' fonts.gstatic.com; style-src 'self' fonts.googleapis.com; font-src fonts.gstatic.com; connect-src 'self' analytics.google.com; img-src 'self' fonts.gstatic.com; object-src 'none'; base-uri 'self'; form-action 'self'; frame-ancestors 'none'; block-all-mixed-content;";

        $response = $next($request);

        $response->headers->set('Content-Security-Policy', $policy);

        return $response;
    }
}