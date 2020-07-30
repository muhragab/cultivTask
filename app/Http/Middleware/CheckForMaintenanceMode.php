<?php

namespace App\Http\Middleware;

use App\Traits\ResponseCustom;
use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as Middleware;

class CheckForMaintenanceMode extends Middleware
{
    use ResponseCustom;
    protected $request;
    protected $app;

    public function __construct(Application $app, Request $request)
    {
        $this->app = $app;
        $this->request = $request;
    }

    public function handle($request, Closure $next)
    {
        if ($this->app->isDownForMaintenance() &&
            !in_array($this->request->getClientIp(), ['86.10.190.248', '86.4.7.24'])) {
            return $this->sendError('Be right back!', 503);
        }

        return $next($request);
    }

}
