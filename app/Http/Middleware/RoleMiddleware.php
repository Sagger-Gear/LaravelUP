<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        # получаем роль авторизованного пользователя
        $userRole = Auth::user()->role;

        # создаем массив из ролей
        $roles = explode(',', $role);

        # проверяет роль пользователя, подходит ли она под роли проверки
        if(in_array($userRole, $roles))
            return $next($request);
        else
            return redirect()->route('login');
    }
}
