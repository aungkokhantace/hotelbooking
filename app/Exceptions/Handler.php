<?php

namespace App\Exceptions;

use Exception;

use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
       
        // if(!($e instanceof NotFoundHttpException)){         //for email format validation case, if email format is not valid, redirect to create form
        if(!($e instanceof NotFoundHttpException) && !($e instanceof HttpResponseException)){         //for email format validation case, if email format is not valid, redirect to create form
            if (Auth::guard('User')->check()) {
                return response()->view('core.error.pagenotfound', ['e'=>$e], 404);
            }
            else{
                if ($e instanceof \Illuminate\Session\TokenMismatchException)
                {
                    return redirect()
                        ->back()
                        ->withInput($request->except('_token'))
                        ->with([
                            'session_expired' => true
                        ]);
                }
                return response()->view('core.error.pagenotfound_frontend', ['e'=>$e], 404);
            }
        }

        return parent::render($request, $e);
    }
}
