<?php

namespace App\Exceptions;

use App\Traits\ResponseCustom;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class Handler extends ExceptionHandler
{
    use ResponseCustom;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Throwable $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // if your api client has the correct content-type this expectsJson()
        // should work. if not you may use $request->is('/api/*') to match the url.
        if ($request->expectsJson()) {
            if ($exception instanceof UnauthorizedHttpException) {
                return $this->sendError('Unauthorized', 401);
            }
        }
        if ($exception instanceof ModelNotFoundException) {
            return $this->sendError('data not found');
        }
        return parent::render($request, $exception);
    }
}
