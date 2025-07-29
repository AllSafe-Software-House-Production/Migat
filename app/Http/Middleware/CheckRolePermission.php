<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRolePermission
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->role === 'superAdmin') {
            return $next($request);
        }

        if (!$user || !$user->rule) {
            return response()->json(['message' => 'No permission rule assigned.'], 403);
        }

        $allowedRoutes = $user->rule->roles_list->pluck('route')->toArray() ?? [];

        $currentRoute = '/' . ltrim($request->route()->uri(), '/');

        if (str_starts_with($currentRoute, '/api/')) {
            $currentRoute = substr($currentRoute, 4);
        }

        if (!in_array($currentRoute, $allowedRoutes)) {
            return response()->json(['message' => 'You do not have permission to access this module.'], 403);
        }

        return $next($request);
    }
}

