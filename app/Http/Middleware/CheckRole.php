<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $userRole = Auth::user()->account_type?->value;

        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Unauthorized access');
    }
}
