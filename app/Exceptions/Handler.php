<?php

namespace App\Exceptions;

use App\Models\User;
use App\Traits\APIResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Throwable;
// this calls  for render return value type options
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse ;


class Handler extends ExceptionHandler
{
    use  APIResponseTrait;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public  function render($request  , Throwable $e ): Response|JsonResponse|RedirectResponse|SymfonyResponse
    {
        if ($e instanceof AccessDeniedHttpException ){
            return $this->errorResponse( $e->getMessage());
        }
        if ($e instanceof ModelNotFoundException ) {
            $modelName = match ($e->getModel()) {
                User::class => 'User',
                default => 'Record'
            };
            return $this->errorResponse('model not found ',$modelName.' not found ');
        }
       return parent::render($request , $e);
    }
}
