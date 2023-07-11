<?php

namespace Sashagm\Money\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SendMoney
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        if (!config('money.check.active')) {
            return $next($request);
        }

        $colum = config('money.check.save_colum');
        $val = config('money.check.save_value');
        $guard = config('money.check.guard');

        $user = Auth::guard($guard)->user();

        if (!$user) {
            abort(403, 'У вас нет прав для перевода!');
        }

        if (!in_array($user->$colum, $val)) {
            abort(403, 'У вас нет прав для перевода!');
        }

        return $next($request);
    }
    
}
