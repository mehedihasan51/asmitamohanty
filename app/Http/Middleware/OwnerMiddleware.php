<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('api')->check() && Auth::guard('api')->user()->hasRole('owner') && Auth::guard('api')->user()->status == 'active' && Auth::guard('api')->user()->otp_verified_at) {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized action.']);
    }
}

