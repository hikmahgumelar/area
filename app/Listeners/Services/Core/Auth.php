<?php

namespace App\Libraries\Services\Core;

use Closure;
use Illuminate\Http\Request;
use App\Libraries\Services\{
    UserService,
    Core\Exception as ServiceException
};

class Auth
{
    /**
     * Middleware auth service
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public static function middleware(Request $request, Closure $next)
    {
        $info = self::info();

        if (is_null($info)) :
            return response()->json(['message' => 'Tidak ada otorisasi'], 401);
        endif;

        return $next($request);
    }

    /**
     * Get auth info
     *
     * @return mixed
     */
    public static function info()
    {
        $auth   = self::getAuthorization();
        $token  = self::getToken($auth);

        try {
            $authService = UserService::post('api/v1/auth/validate-token', [
                'token' => $token
            ]);

            ServiceException::on($authService);

            return $authService->data;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get authorization header
     *
     * @return mixed
     */
    private static function getAuthorization()
    {
        return isset($_SERVER['HTTP_AUTHORIZATION']) ? $_SERVER['HTTP_AUTHORIZATION'] : false;
    }

    /**
     * Get token
     *
     * @param string $authorization
     * @return string
     */
    private static function getToken(string $authorization)
    {
        return substr($authorization, 7);
    }

    /**
     * Get auth user info
     *
     * @return mixed
     */
    public static function user()
    {
        $info = self::info();

        if (is_null($info)) :
            return null;
        endif;

        try {
            $user = UserService::get("api/v1/user/service/by-user-id/{$info->user_id}");

            ServiceException::on($user);

            return $user->data;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * get auth user
     *
     * @return bool
     */
    public static function check()
    {
        $info = self::info();

        if (is_null($info)) :
            return false;
        endif;

        return true;
    }
}
