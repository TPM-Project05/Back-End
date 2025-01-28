<?php

// app/Http/Middleware/AdminMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $Team = auth()->user();

        if ($Team->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
