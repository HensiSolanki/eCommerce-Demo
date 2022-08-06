<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($this->isHttpException($exception)) {
            $errCode = $exception->getStatusCode();

            if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
                if ($request->ajax()) {
                    $result['message'] = "You haven't permission for this action.";
                    $result['code'] = $errCode;
                    return response()->json($result, $errCode);
                }
            }

            if (!$request->is('docs/api-docs.json') && view()->exists('errors.' . $errCode)) {
                return response()->view('errors.' . $errCode);
            }
        }

        return parent::render($request, $exception);
    }
}
