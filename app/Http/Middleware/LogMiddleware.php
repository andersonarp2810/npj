<?php

namespace App\Http\Middleware;

use App\Entities\Log;
use Auth;
use Closure;
use Illuminate\Support\Facades\Route;

class LogMiddleware
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
        $params = Route::getCurrentRequest()->all();
        unset($params['_token']);
        unset($params['password']);


        $log = [
            'user_id' => Auth::guest() ? null : Auth::user()->id,
            'route' => Route::current()->uri,
            'request' => json_encode($params),
        ];


        Log::create($log);

        return $next($request);
    }
}
