<?php

namespace App\Exceptions;

use App\Http\Controllers\Controller;
use App\Models\Interfaces\IStatusCode;
use DomainException;
use Exception;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        // $this->reportable(function (Throwable $e) {

        // });
        $this->renderable(function (Exception $ex, Request $request) {
            if ($ex instanceof DomainException) {
                return Controller::sendResponse([$ex->getMessage()], IStatusCode::BAD_REQUEST);
            } else if ($ex instanceof SignatureInvalidException) {
                return Controller::sendResponse([$ex->getMessage()], IStatusCode::BAD_REQUEST);
            } else if ($ex instanceof ExpiredException) {
                return Controller::sendResponse([$ex->getMessage()], IStatusCode::UNAUTHORIZED);
            } else {
            }
        });
    }
}
