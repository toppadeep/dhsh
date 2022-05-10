<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::where('token', $request->bearerToken())->first();
        if ($user->status !== 2) {
            return response()->json(["status" => false, "message" => "Доступ запрещён"], 403);
        }

        return $next($request);
    }
}
