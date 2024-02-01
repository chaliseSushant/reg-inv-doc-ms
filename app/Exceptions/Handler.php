<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (ErrorPageException $e, $request) {
            //return response()->view('dashboard.pages.errors',[] ,502);
            Log::error('['.$e->getCode().'] "'.$e->getMessage().'" on line '.$e->getTrace()[0]['line'].' of file '.$e->getTrace()[0]['file']);
            return response()->json(['message' => 'Error Page Exception'],404);
        });
    }

    public function report(\Exception|Throwable $e)
    {
        if (!config('app.debug')) {
            Log::error('['.$e->getCode().'] "'.$e->getMessage().'" on line '.$e->getTrace()[0]['line'].' of file '.$e->getTrace()[0]['file']);
        } else {
            parent::report($e);
        }
    }

}
