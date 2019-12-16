<?php

namespace App\Helpers;

use Carbon\Carbon;

class TokenTime
{

    /**
     * Expired time setting
     *
     * @param strind $type
     * @return string
     */
    public static function for($type)
    {
        $now        = Carbon::now();
        $expired    = null;

        switch ($type) :
            case 'principal':
                $expired = $now->addYear();
                break;
            default:
                $expired = $now->addDays(15);
                break;
        endswitch;

        return $expired->format('Y-m-d H:i:s');
    }
}