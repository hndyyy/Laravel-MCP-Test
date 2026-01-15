<?php

namespace App\Http\Middleware;

use Closure;

class ContentSecurityPolicy
{
    public function handle($request, Closure $next)
    {
        $nonce = base64_encode(random_bytes(16));
        $request->attributes->set('csp_nonce', $nonce);

        $response = $next($request);

        $policy = "default-src 'self'; script-src 'self' 'nonce-".$nonce."'; style-src 'self' 'nonce-".$nonce."' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; connect-src 'self'; img-src 'self' data:;";
        $response->headers->set('Content-Security-Policy', $policy);

        return $response;
    }
}