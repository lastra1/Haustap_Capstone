<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class RoleMiddleware
{
    /**
     * Enforce role-based access control using bearer token.
     * Usage: middleware('role'), middleware('role:client'), middleware('role:admin').
     */
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['success' => false, 'message' => 'missing bearer token'], 401);
        }

        // Resolve user via remember_token, which we set on login.
        $user = User::where('remember_token', $token)->first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'invalid token'], 401);
        }

        // Effective roles = users.role + user_roles entries
        $effective = [];
        if ($user->role) { $effective[] = $user->role; }
        $extra = DB::table('user_roles')->where('user_id', $user->id)->pluck('role')->all();
        foreach ($extra as $r) { $effective[] = (string) $r; }
        $effective = array_values(array_unique($effective));

        // If no specific roles requested, just require authentication
        if (empty($roles)) {
            $request->attributes->set('auth_user', $user);
            return $next($request);
        }

        $required = array_map(fn($r) => strtolower(trim($r)), $roles);
        $hasRole = false;
        foreach ($effective as $r) {
            if (in_array(strtolower($r), $required, true)) { $hasRole = true; break; }
        }
        if (!$hasRole) {
            return response()->json(['success' => false, 'message' => 'forbidden: insufficient role', 'roles' => $effective], 403);
        }

        $request->attributes->set('auth_user', $user);
        return $next($request);
    }
}