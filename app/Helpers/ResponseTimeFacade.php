<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Facade;

class ResponseTimeFacade extends facade
{
    protected static function getFacadeAccessor()
    {
        return 'ResponseTime';
    }
}