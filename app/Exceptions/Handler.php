<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        } elseif ($e instanceof ModelNotFoundException) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'msg' => 'Página não encontrada.']);
            }else{
                $e = new HttpException(404, $e->getMessage());
            }
        } elseif ($e instanceof AuthenticationException) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'msg' => 'Não autenticado.']);
            }else{
                return $this->unauthenticated($request, $e);
            }
        } elseif ($e instanceof AuthorizationException) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'msg' => 'Sem permissão para está ação.']);
            }else{
                $e = new HttpException(401, $e->getMessage());
            }
        } elseif ($e instanceof ValidationException && $e->getResponse()) {
            $e = new ValidationException(404, $e->getMessage());
        }

        if ($this->isHttpException($e)) {
            return $this->toIlluminateResponse($this->renderHttpException($e), $e);
        } else {
            return $this->toIlluminateResponse($this->convertExceptionToResponse($e), $e);
        }
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Não autenticado.'], 401);
        }

        return redirect()->guest('login');
    }
}
