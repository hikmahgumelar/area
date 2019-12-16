<?php

namespace App\Http\Middleware;

use Closure;
use App\Libraries\Services\Core\Auth;
use App\Helpers\Access as AccessModule;

class Access
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
//        if (Auth::check()) {
//            if (AccessModule::module($request->path(), Auth::user()) == false) {
//                return response()->json(['message' => 'Tidak ada otorisasi'], 401);
//            }
//        }

        return $next($request);
    }
}
