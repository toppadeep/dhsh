<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class Auth
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
        if (!User::where('token', $request->bearerToken())->first()) { // Если пользователь не авторизован
            return response()->json(["status" => false, "message" => "Вы неавторизованы"], 401); // Возваращаем ошибку
        } else {
            return $next($request)  ; // В ином случае пропускаем дальше
        }
    }
}
