<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
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
        if ($request->isMethod('OPTIONS')) {
            $provider = $request->header('Access-Control-Request-Headers');
            $headers = [
                'Access-Control-Allow-Headers' => $provider,
                'Access-Control-Allow-Methods' => 'POST, GET',
                'Access-Control-Expose-Headers' => 'api-version',
                'Access-Control-Allow-Origin' => $request->header('Origin', '*'),
            ];
            return response("", 204, $headers);
        }
        $response = $next($request);
        $response->headers->set('api-version', '1.1.0');
        return $response;
    }
}
