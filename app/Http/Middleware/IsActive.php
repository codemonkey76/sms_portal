<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->isActive) {
            return $next($request);
        }

        return redirect()->route('inactive');
    }
}
