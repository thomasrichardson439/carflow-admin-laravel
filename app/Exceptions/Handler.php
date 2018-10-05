<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
    public function report(Exception $exception)
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
    public function render($request, Exception $exception)
    {
        if (strpos($request->path(), 'api') !== false) {

            if ($exception instanceof ValidationException) {
                return response()->json([
                    'status' => 'failed',
                    'error' => [
                        'type' => 'validation',
                        'message' => 'The given data was invalid.',
                        'errors' => $exception->errors(),
                    ],
                ], $exception->status);

            } elseif ($exception instanceof HttpException) {

                $error = [
                    'type' => 'http',
                    'message' => $exception->getMessage(),
                ];

                if (getenv('APP_DEBUG')) {
                    $error['trace'] = $exception->getTrace();
                }

                return response()->json([
                    'status' => 'failed',
                    'error' => $error,
                ], $exception->getStatusCode());

            } else {

                $error = [
                    'type' => 'critical',
                    'message' => $exception->getMessage(),
                ];

                if (getenv('APP_DEBUG')) {
                    $error['trace'] = $exception->getTrace();
                }

                return response()->json([
                    'status' => 'failed',
                    'error' => $error,
                ], 500);
            }
        }

        return parent::render($request, $exception);
    }
}
