<?php

namespace App\Http\Middleware\Interserver;

use App\Traits\SuccessMessage;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterconnectPermission
{
    use SuccessMessage;

    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('api')->check())
        {
            return response()->json($this->getErrorMessage('unauthenticated'),201);
        }
        else
        {
            if (!Auth::guard('api')->user()->department->interconnect)
            {
                return response()->json($this->getErrorMessage('interconnect not permitted'),201);
            }
            else
            {
                return $next($request);
            }
        }



    }
}
