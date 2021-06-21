<?php

namespace App\Http\Middleware;

use Closure;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

class ApiAuth
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
        $token = $request->bearerToken();
        $authToken = $request->header("Auth");
        if ($token != env("API_BEARER") && $authToken != env("API_AUTH")) {
            return response('Unauthorized', 401)
                ->header('Content-Type', 'text/plain');
        }

        return $next($request);
    }
}