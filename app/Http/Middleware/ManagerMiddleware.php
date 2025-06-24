<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerMiddleware
{
    /**
     * Проверка, является ли пользователь менеджером
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Вы должны войти в систему.');
        }

        if (Auth::user()->role !== 'manager') {
            return redirect()->route('home')->with('error', 'У вас нет доступа к этой странице.');
        }

        return $next($request);
    }
}
