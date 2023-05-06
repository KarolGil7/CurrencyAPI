<?php

namespace App\Http\Middleware;

use App\Helpers\PermissionRolesHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user->hasRole(PermissionRolesHelper::ADMIN_ROLE)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
