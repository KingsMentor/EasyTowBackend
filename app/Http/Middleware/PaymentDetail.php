<?php

namespace App\Http\Middleware;

use Closure;

class PaymentDetail
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
        if(auth()->check()){
            if(auth()->user()->type == 0){
                if(auth()->user()->account_name)
                    return $next($request);
                else
                    return redirect()->to('/registration');
            }elseif(auth()->user()->type == 1 || auth()->user()->type == 2){
                if(auth()->user()->companies->count() > 0) {
                    if(!session('company')) {
                        session(['company' => json_encode(auth()->user()->companies[0])]);
                    }
                    return $next($request);
                }else {
                    return redirect()->to('/registration');
                }
            }
            return $next($request);
        }else{
            return redirect()->to('/registration');
        }
    }
}
