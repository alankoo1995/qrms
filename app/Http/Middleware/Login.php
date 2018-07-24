<?php

namespace App\Http\Middleware;
use App\Http\Model\User;

use Closure;

class Login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!session('user')){
            return redirect('login');
        }
        return $next($request);
    }
}
