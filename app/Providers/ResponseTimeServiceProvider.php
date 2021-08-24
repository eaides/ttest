<?php

namespace App\Providers;

use App\Helpers\ResponseTime;
use Illuminate\Support\ServiceProvider;

class ResponseTimeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ResponseTime', function(){
            return new ResponseTime;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
