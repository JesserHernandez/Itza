<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $allowVendorOnly = 'false')
    {
        $user = $request->user();
        if (!$user) {

            return $next($request);
        }

        if ($user->is_vendor) {
            
            return $next($request);
        }

        $allowVendorOnly = filter_var($allowVendorOnly, FILTER_VALIDATE_BOOLEAN);

        if ($allowVendorOnly) {
            abort(403, '¡Vaya...Lo sentimos, no tienes permiso para acceder a esta página!');
        }

        return $next($request);
    }
}