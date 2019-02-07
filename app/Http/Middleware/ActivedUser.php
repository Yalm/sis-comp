<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ActivedUser
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
        if(!Auth('user')->user()->actived)
        {
            Auth('user')->logout();
            return redirect('/admin/login')->with('error','Lo sentimos su cuenta esta suspendida.');
        }
        return $next($request);
    }
}
