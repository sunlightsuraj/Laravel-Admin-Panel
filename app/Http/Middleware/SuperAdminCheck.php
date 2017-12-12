<?php

namespace App\Http\Middleware;

use Closure;

class SuperAdminCheck
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
        if(!session('super_user'))
            return redirect()->route('admin_dashboard');

        return $next($request);
    }
}
