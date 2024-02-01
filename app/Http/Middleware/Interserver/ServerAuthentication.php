<?php

namespace App\Http\Middleware\Interserver;

use Closure;
use Illuminate\Http\Request;

class ServerAuthentication
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->hasHeader('Interconnect-Token')) {
            if ($request->header('Interconnect-Token') == sha1(config('organization.private_key'))) {
                return $next($request);
            }
            else
            {
                return response()->json(['error'=> 'Request source not allowed. Request not validated.'],401);
            }
        }
        else
        {
            return response()->json(['error'=> 'Request source not allowed. Request not allowed.'],401);
        }

    }
}
