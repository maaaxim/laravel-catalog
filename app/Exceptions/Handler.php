<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
	 * @param  \Exception $exception
	 * @return void
	 * @throws Exception
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
		if ($request->is('api/*')) {
			switch (get_class($exception)) {
				case AuthorizationException::class:
					return response()->json(['message' => 'Forbidden.'], 403);
				case MethodNotAllowedHttpException::class:
					return response()->json(['message' => 'Not allowed.'], 405);
				case NotFoundHttpException::class:
					return response()->json(['message' => 'Route not exist.'], 404);
				case ModelNotFoundException::class:
					return response()->json(['message' => 'Resource not found.'], 404);
				case ApplicationException::class:
					return response()->json(['message' => $exception->getMessage()], 500);
			}
		}

		return parent::render($request, $exception);
    }
}
