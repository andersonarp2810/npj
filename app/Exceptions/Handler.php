<?php

namespace App\Exceptions;

use Exception;
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
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            return redirect()
                   ->back()
                   ->withInput($request->except(['password', 'password_confirmation']))
                   ->with('erro', 'A requisição expirou por inatividade. Por favor, tente novamente.');
        }

        else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException){
            return redirect()
                   ->back()
                   ->withInput($request->except(['password', 'password_confirmation']))
                   ->with('erro', 'Página não encontrada.');
        }

        else if($exception instanceof \Illuminate\Database\QueryException){
            return redirect()
                   ->back()
                   ->withInput($request->except(['password', 'password_confirmation']))
                   ->with('erro', 'Erro de conexão.');
        }

        return parent::render($request, $exception);
    }
}
