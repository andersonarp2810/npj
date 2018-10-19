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
        $params = $request->all();
        unset($params['_token']); # não interessa, não é legível
        unset($params['password']); # óbvio


        $log = [
            'user_id' => Auth::guest() ? null : Auth::user()->id,
            'route' => Route::current()->uri,
            'request' => json_encode($params),
            # ação (get, post, etc.) aparece se der dd() mas é null aqui? friscura véa
        ];


        Log::create($log);

        return $next($request);
    }
}
