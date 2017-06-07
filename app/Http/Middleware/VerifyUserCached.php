<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class VerifyUserCached
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
        if (is_null($request->session()->get('cpf'))){
           return redirect()->route('index');
        }
        return $next($request);
    }
}
