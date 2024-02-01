<?php

namespace App\Facade;

use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Facade;

class LogActivityFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return LogActivity::class;
    }
}
