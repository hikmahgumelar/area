<?php

namespace App\Http\Middleware;

use Closure;
use App\Libraries\Services\Core\Auth;

class Service
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
        if ($request->header('Access-From') != 'service'){
            return response()->json(['message' => 'Tidak ada otorisasi'], 401);
        }

        return $next($request);
    }
}
