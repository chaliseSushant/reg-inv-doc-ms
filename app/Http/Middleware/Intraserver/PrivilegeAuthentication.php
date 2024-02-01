<?php

namespace App\Http\Middleware\Intraserver;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrivilegeAuthentication
{
    public function handle(Request $request, Closure $next, $privilege)
    {
        $identifier = explode('_',$privilege)[0];
        $crud = explode('_',$privilege)[1];
        if (Auth::guard('api')->check())
        {
            if (Auth::guard('api')->user()->hasPrivilege($identifier,$crud))
            {
                return $next($request);
            }
            else
            {
                return response()->json(['error'=> 'Insufficient Privilege'],401);
            }
        }
        else
        {
            return response()->json(['error'=> 'Unauthenticated'],403);
        }
    }
}
