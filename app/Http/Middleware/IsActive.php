<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Closure;
use Illuminate\Http\Request;

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
