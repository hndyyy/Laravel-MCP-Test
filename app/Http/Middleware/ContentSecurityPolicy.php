<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next)
    {
        $policy = "default-src 'self'; script-src 'self' 'unsafe-inline' www.google-analytics.com; font-src 'self' fonts.gstatic.com gstatic.com; style-src 'self' 'unsafe-inline' https:; connect-src 'self'; img-src 'self' data:;";

        $response = $next($request);
        $response->header('Content-Security-Policy', $policy);
        return $response;
    }
}