<?php

namespace App\Http\Middleware;

use Closure;
use App\Libraries\Services\Core\Auth;

class AuthService
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
        return Auth::middleware($request, $next);
    }
}
