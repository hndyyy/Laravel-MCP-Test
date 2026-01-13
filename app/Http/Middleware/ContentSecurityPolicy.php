<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $frontendViteDomain = 'http://localhost:3000'; // Vite development server for frontend
        $backendViteDomain = 'http://localhost:8080'; // Vite development server for backend (if using different port)
        $googleAnalyticsDomain = 'https://www.googletagmanager.com';
        $googleFontsDomain = 'https://fonts.googleapis.com';
        $googleFontsCDN = 'https://fonts.gstatic.com';

        $policy = "default-src 'self'; script-src 'self' $frontendViteDomain $backendViteDomain $googleAnalyticsDomain $googleFontsCDN 'nonce-{{ csp_nonce }}' 'strict-dynamic' ; connect-src 'self' $googleAnalyticsDomain; font-src 'self' $googleFontsDomain $googleFontsCDN data:; img-src 'self' $googleFontsCDN data:; style-src 'self' $googleFontsDomain; frame-src $googleAnalyticsDomain;";

        $response->header('Content-Security-Policy', $policy);
        return $response;
    }
}