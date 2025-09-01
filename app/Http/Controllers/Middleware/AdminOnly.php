<?php
namespace App\Http\Middleware;

use Closure;

class AdminOnly {
    public function handle($request, Closure $next) {
        if (!$request->user() || !$request->user()->isAdmin()) {
            abort(403);
        }
        return $next($request);
    }
}