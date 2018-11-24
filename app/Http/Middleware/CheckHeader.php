<?php

namespace App\Http\Middleware;

use Closure;

class CheckHeader
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
        if ($request->header('x-api-key') == 'inikuncinya') {
            return $next($request);
        } else {
            $code = "FAILED";
            $description = "api-key missmatch";
            return response()->json(compact('code','description'));
        }
    }
}
