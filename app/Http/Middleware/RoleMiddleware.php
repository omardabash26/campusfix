<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'אין לך הרשאה לגשת לדף זה.');
        }

        if (!auth()->user()->is_active) {
            auth()->logout();
            return redirect()->route('login')->withErrors(['identity_number' => 'החשבון שלך אינו פעיל.']);
        }

        return $next($request);
    }
}