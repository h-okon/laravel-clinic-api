<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $usr = Auth::user();
        if(isset($usr->doctor()->id))
        {
            return $next($request);
        }
        else
            return response() -> json([
                "error" => "You are not a doctor - unauthorized to perform this operation."
            ], 401);

    }
}
