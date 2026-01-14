<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next)
    {
        // Generate a secure random nonce for script-src
        $nonce = base64_encode(random_bytes(16));
        
        // Set the nonce on the request for use in views
        $request->attributes->set('csp_nonce', $nonce);

        // Content Security Policy rules as single line string
        $policy = "default-src 'self'; script-src 'self' 'nonce-" . $nonce . "'; connect-src 'self'; img-src 'self' data:; font-src 'self' https://fonts.gstatic.com;
        style-src 'self' https://fonts.googleapis.com; child-src 'none'; object-src 'none'; frame-src 'none'; frame-ancestors 'none';
        form-action 'self'; upgrade-insecure-requests; block-all-mixed-content;";

        $response = $next($request);

        // Set the Content-Security-Policy header
        $response->headers->set("Content-Security-Policy", $policy);

        return $response;
    }
}