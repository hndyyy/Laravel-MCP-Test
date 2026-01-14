<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next)
    {
        $policy = "default-src 'self'; script-src 'self' https://www.google-analytics.com 'unsafe-inline'; style-src 'self' https://fonts.googleapis.com 'unsafe-inline'; font-src 'self' https://fonts.gstatic.com https://fonts.googleapis.com; img-src 'self' data:";

        $response = $next($request)->header('Content-Security-Policy', $policy);

        if ($request->is('admin') || $request->is('admin/*')) {
            $response->header('Content-Security-Policy', "${policy}; report-uri /admin/csp-report");
        }

        return $response;
    }

    public function terminate(Request $request, $response) {}
}