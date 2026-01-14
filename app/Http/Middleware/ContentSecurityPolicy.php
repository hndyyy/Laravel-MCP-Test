<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next)
    {
        $nonce = bin2hex(random_bytes(16));
        
        $policy = "default-src 'self'; script-src 'self' 'nonce-".$nonce."' fonts.googleapis.com www.google-analytics.com; font-src 'self' fonts.googleapis.com; style-src 'self' 'nonce-".$nonce."' fonts.googleapis.com; connect-src 'self' www.google-analytics.com; object-src 'none'";

        $request->attributes->set('csp_nonce', $nonce);
        
        $response = $next($request);
        $response->header('Content-Security-Policy', $policy);

        return $response;
    }
}