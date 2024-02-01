<?php

namespace App\Http\Middleware\Intraserver;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $department)
    {
        if (Auth::check()) {
            if (Auth::user()->isInDepartment($department)) {
                return $next($request);
            }
            else
            {
                return redirect()->back();
            }
        }
    }
}
