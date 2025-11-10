<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserPosition
{
    public function handle(Request $request, Closure $next, ...$positions)
    {
        if (!$request->user() || !in_array($request->user()->position, $positions)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized.'], 403);
            }
            return redirect()->back()->with('error', 'You do not have permission to perform this action.');
        }

        return $next($request);
    }
}