<?php

namespace App\Http\Middleware;

use Closure;

class AdminCheckMiddleware
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
		if(!session('sess_admin') && !session('user_id'))
			return redirect()->route('admin_login');

        return $next($request);
    }
}
