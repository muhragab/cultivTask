<?php namespace App\Http\Middleware;

use App\Traits\ResponseCustom;
use Closure;
use Illuminate\Http\Request;

class Cors
{
    use ResponseCustom;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', '*');
        $response->headers->set('Access-Control-Allow-Headers', '*');
        return $response;
    }

}
