<?php

namespace App\Http\Middleware;

use App\Services\RailwayService;
use Closure;
use Illuminate\Http\Request;

class ServiceNotLockedMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $service = (new RailwayService())->getRailwayService();
        if ($service->locked == 1) {
            return redirect()->route('maintenance');
        } else {
            return $next($request);
        }
    }
}
