<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Helpers\ResponseTime getResponseTime(string $url)
 */
class ResponseTimeFacade extends facade
{
    protected static function getFacadeAccessor()
    {
        return 'ResponseTime';
    }
}