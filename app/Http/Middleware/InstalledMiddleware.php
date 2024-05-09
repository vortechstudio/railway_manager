<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InstalledMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if($request->user()->railway()->exists() && $request->user()->railway->installed) {
            return $next($request);
        } else {
            return redirect()->route('auth.install');
        }
    }
}
