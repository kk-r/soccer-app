<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
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

        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
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
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $exception
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $errorCode = null;
        $httpResponseCode = null;
        $errorMsg = [];
        $errorArray = null;
        if ($exception instanceof AppException) {
            $errorCode = $exception->getCode();
            $errorMsg = $exception->getMessage();
            $httpResponseCode = $exception->getHttpResponseCode();
            $errorArray = $exception->getErrors();
        } else {
            return parent::render($request, $exception);
        }

        if (is_string($errorArray)) {
            $errorArray = null;
        }

        $httpResponseCode = (empty($httpResponseCode)) ? 404 : $httpResponseCode;
        $errorCode = (empty($httpResponseCode)) ? $errorCode : $httpResponseCode;
        $responseArray = $this->createErrorResponse($errorCode, $httpResponseCode, $errorMsg, $errorArray);

        return response($responseArray, $httpResponseCode);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request                 $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     *
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect('/login');
    }

    public function createErrorResponse(
        $errorCode,
        $httpResponseCode,
        $errorMsg,
        \Illuminate\Support\MessageBag $errorMsgs = null
    ) {
        $response = [
            'status'  => [
                'success'   => false,
                'http_code' => $errorCode,
                'message'   => $errorMsg,
            ],
            'data'    => []
        ];

        if (!is_null($errorMsgs) && $errorMsgs->any()) {
            $response['data']['validation_errors'] = $errorMsgs;
        }

        return $response;
    }
}
