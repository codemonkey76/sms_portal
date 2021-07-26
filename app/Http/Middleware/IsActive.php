<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsActive
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->isActive) {
            return $next($request);
        }

        return redirect()->route('inactive');
    }
}
