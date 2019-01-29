<?php

namespace App\Http\Middleware;

use Closure;

class CheckEmptyCart
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
        $cart = \Cart::isEmpty();
        if($cart)
        {
            return redirect('/cart');
        }
        else if(!Auth()->user()->verifiedData())
        {
            return redirect('/account/complete-profile');
        }
        return $next($request);
    }
}
