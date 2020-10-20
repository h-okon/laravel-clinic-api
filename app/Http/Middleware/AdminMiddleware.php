<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminMiddleware
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
        if($usr->is_elevated == True)
        {
            return $next($request);
        }
        else
            return response() -> json([
                "error" => "You are not authorized to perform this operation."
            ], 401);

    }
}
