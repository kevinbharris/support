<?php

namespace KevinBHarris\Support\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

/**
 * Support Permission Middleware
 * 
 * Checks if the authenticated user has the required permission
 * to access a route. Integrates with Bagisto's ACL system.
 */
class SupportPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permission
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $permission)
    {
        if (! auth()->check()) {
            return redirect()->route('admin.session.create');
        }

        if (! Gate::allows($permission)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
