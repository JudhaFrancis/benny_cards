<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DebugRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('POST')) {
            \Log::info('Middleware POST detected', [
                'url' => $request->fullUrl(),
                'data' => $request->all(),
                'ip' => $request->ip(),
                'referer' => $request->header('referer'),
            ]);
        }
        return $next($request);
    }
}
