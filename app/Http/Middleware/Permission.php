<?php

namespace App\Http\Middleware;

use Closure;
use App\Libraries\Services\Core\Auth;
use App\Libraries\Services\{
    UserService,
    Core\Exception as ServiceException
};

use Laravel\Lumen\Http\Request as Req;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permissions)
    {
        if (Auth::check()) {
            $user = Auth::info();
            if ($request->header('Access-From') == "service"){
                return $next($request);
            }
            $actions  = explode('|', $permissions);
            $user_permissions = $user->permissions;
            if (in_array($actions[0], $user_permissions)){
                return $next($request);
            }else{
                return response()->json(['message' => 'Tidak ada otorisasi'], 401);
            }
        }

        return response()->json(['message' => 'Tidak ada otorisasi'], 401);
    }
}
