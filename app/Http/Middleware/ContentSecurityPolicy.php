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

        $policy = "default-src 'self'; script-src 'self' 'nonce-{$nonce}' fonts.googleapis.com www.google.com www.googletagmanager.com dl.google.com; connect-src 'self'; img-src 'self' data:; font-src 'self' fonts.gstatic.com; style-src 'self' fonts.googleapis.com 'unsafe-inline'; frame-src 'none'; child-src 'none'; object-src 'none'; media-src 'self'; form-action 'self'; base-uri 'self'; plugin-types application/pdf application/x-shockwave-flash video/quicktime image/svg+xml; upgrade-insecure-requests;";

        $response->headers->set('Content-Security-Policy', $policy);

        return $response;
    }
}