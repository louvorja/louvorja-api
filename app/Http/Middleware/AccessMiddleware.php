<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $access = null)
    {
        if (!Auth::user()->is_admin) {
            $method = $request->getMethod();
            $permission = $access . ($method == "POST" ? ".insert" : ($method == "PUT" ? ".update" : ($method == "DELETE" ? ".delete" : "")));

            if (!in_array($permission, Auth::user()->permissions ?? [])) {
                return response()->json(['error' => 'Você não tem permissão para executar esta ação. Permissão necessária: "' . $permission . '"'], 401);
            }
        }

        return $next($request);
    }
}
