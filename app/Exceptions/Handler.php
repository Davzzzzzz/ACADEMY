<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    // <--- Agrega esto
    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*')) {
            return response()->json([
                'message' => $exception->getMessage(),
                'status' => $exception->getCode()
            ], $this->getHttpStatusCode($exception));
        }

        return parent::render($request, $exception);
    }

    protected function getHttpStatusCode($exception)
    {
        if ($exception instanceof AuthenticationException) {
            return 401;
        }
        if ($exception instanceof NotFoundHttpException) {
            return 404;
        }
        return 500;
    }
}
