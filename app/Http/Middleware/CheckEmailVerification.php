<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CheckEmailVerification
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user) {
            return $next($request);
        }

        if ($request->routeIs('verification.notice', 'verification.send', 'verification.verify')) {
            return $next($request);
        }

        if ($user->hasVerifiedEmail()) {
            return $next($request);
        }

        $deadline = $user->created_at->addDays(7);

        if (Carbon::now()->greaterThan($deadline)) {
            return Inertia::render('Auth/VerifyEmail', [
                'status' => session('status'),
                'isBlocked' => true,
            ]);
        }

        return $next($request);
    }
}
