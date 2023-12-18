<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\APIResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException ;
use Illuminate\Http\JsonResponse;
use Throwable as ThrowableAlias;


class AuthController extends Controller
{
    use APIResponseTrait;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login(): JsonResponse
    {
        try {
            $credentials = request(['email', 'password']);
            if (!$token = auth()->attempt($credentials)) {
                return $this->errorResponse('Unauthorized', 'Access Denied: Please provide valid credentials to proceed');
            }
            return $this->loggedInSuccessfully($token);
        } catch (ThrowableAlias $th) {
            return $this->errorResponse($th->getMessage() ,  );
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        try {
             return $this->successResponse(['user ' => auth()->user()], 'this is me ');
        } catch (ThrowableAlias $th) {
            return $this->errorResponse($th->getMessage() ,  ' some think wrong , please try again ');
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        try {
            auth()->logout();
            return $this->successResponse(message: 'Successfully logged out');
        } catch (ThrowableAlias $th) {
            return $this->errorResponse($th->getMessage() ,  ' some think wrong , please try again ');
        }
    }
}
