<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ApiSessionAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            $routeName = $request->route()->getPrefix();
            if (strpos($routeName, 'api') === 0) {
                return response()
                    ->json([
                        'status'  => [
                            'success'   => false,
                            'http_code' => 401,
                            'message'   => "Unauthorized",
                        ],
                        'data'    => []
                    ], 401);
            }
            return redirect('/login');
        }
        return $next($request);
    }
}
