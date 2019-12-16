<?php

namespace App\Helpers;

class Access
{

    /**
     * Access module user
     *
     * @param object $user, string $uri
     * @return bool
     */
    public static function module($uri, $user)
    {
        if ($uri) {
            $uri = explode('/', $uri);
            if (isset($uri[0]) && $uri[0]=='api') {
                if (isset($uri[3])) {
                    if ($uri[3]==$user->type || in_array($uri[3], ['general', 'source', 'service'])==true) {
                        return true;
                    }
                    // bypass login principal in paguyuban
                    if ($uri[3]=='paguyuban' && $user->type=='principal' && $user->groups()->count() > 0) {
                        return true;
                    }
                }
            } else {
                return true;
            }
        }
        return false;
    }
}