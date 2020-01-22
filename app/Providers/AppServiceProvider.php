<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Facade\FlareClient\Flare;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if(env('APP_ENV') == 'production'){
            $key = env('FLARE_KEY') ? env('FLARE_KEY') : '';
        }else{
            $key = '';
        }
        Flare::register($key)->registerFlareHandlers();
    }
}
