<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $policy = "default-src 'self'; script-src 'self' https://fonts.gstatic.com https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com https://fonts.googleapis.com; style-src 'self' https://fonts.googleapis.com; img-src 'self' data: https://fonts.gstatic.com; connect-src 'self' https://fonts.gstatic.com https://fonts.googleapis.com";

        $response->headers->set('Content-Security-Policy', $policy);

        return $response;
    }
}