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

        $allowedRoles = $user->rule->roles->pluck('name')->toArray();

        $currentSegment = $request->segment(2);

        if (!in_array($currentSegment, $allowedRoles)) {
            return response()->json(['message' => 'You do not have permission to access this module.'], 403);
        }

        return $next($request);
    }
}

