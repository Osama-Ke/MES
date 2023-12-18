<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse as JsonResponseAlias;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

trait APIResponseTrait
{
    /**
     * Success Response.
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return JsonResponseAlias
     */
    public function successResponse(mixed $data = [], string $message = ''  , int $statusCode = Response::HTTP_OK): JsonResponseAlias
    {
        //check if there is message passed.
        if (!$message)
            $message = Response::$statusTexts[$statusCode];
        // convert $data  to array to make the insert operation easier.
        if (!is_array($data))
        $data = (array)$data;
        //add the message and success to first in the data array.
        $data = Arr::prepend($data,$message,'message ');
        $data = Arr::prepend($data,'true','success ');
        return new JsonResponseAlias($data, $statusCode);
    }

    /**
     * Error Response.
     * 0\=
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return JsonResponseAlias
     */
    public function errorResponse(mixed $data =[] , string $message = '', int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponseAlias
    {
        //check if there is message passed.
        if (!$message)
            $message = Response::$statusTexts[$statusCode];

        $data = [
            'success'=> 'false ',
            'message' => $message,
            'errors' => $data,
        ];
        return new JsonResponseAlias($data, $statusCode);
    }

    /**
     * Response with status code 200.
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponseAlias
     */
    public function okResponse(mixed $data , string $message = ''): JsonResponseAlias
    {
        return $this->successResponse($data , $message);
    }

    /**
     * Response with status code 201.
     *
     * @param mixed $data
     * @param $modelName
     * @return JsonResponseAlias
     */
    public function createdResponse(mixed $data , $modelName ): JsonResponseAlias
    {
        $modelName = $modelName.' created successfully ';
        return $this->successResponse($data, $modelName ,Response::HTTP_CREATED);
    }

    /**
     * Response with status code 204.
     *
     */
    // this method is no contant
    public function noContentResponse(): JsonResponseAlias
    {
            return $this->errorResponse();
    }

    /**
     * Response with status code 400.
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponseAlias
     */
    public function badRequestResponse(mixed $data, string $message = ''): JsonResponseAlias
    {
        return $this->errorResponse($data, $message, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Response with status code 401.
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponseAlias
     */
    public function unauthorizedResponse(mixed $data, string $message = ''): JsonResponseAlias
    {
        return $this->errorResponse($data, $message, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Response with status code 403.
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponseAlias
     */
    public function forbiddenResponse(mixed $data, string $message = ''): JsonResponseAlias
    {
        return $this->errorResponse($data, $message, Response::HTTP_FORBIDDEN);
    }

    /**
     * Response with status code 404.
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponseAlias
     */
    public function notFoundResponse(mixed $data, string $message = ''): JsonResponseAlias
    {
        return $this->errorResponse($data, $message, Response::HTTP_NOT_FOUND);
    }

    /**
     * Response with status code 409.
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponseAlias
     */
    public function conflictResponse(mixed $data, string $message = ''): JsonResponseAlias
    {
        return $this->errorResponse($data, $message, Response::HTTP_CONFLICT);
    }

    /**
     * Response with status code 422.
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponseAlias
     */
    public function unprocessableResponse(mixed $data, string $message = ''): JsonResponseAlias
    {
        return $this->errorResponse($data, $message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Response with status code 200.
     *
     * @param mixed $data
     * @return JsonResponseAlias
     */
    public function loggedInSuccessfully (mixed $data): JsonResponseAlias
    {
        $data = [
            'access_token' => $data,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
        ];
        return $this->successResponse($data , 'user logged in successfully');
    }

    // this method to handel the unknown errors(using in the catch for any think Throwable in general )
    public  function  generalFailureResponse($errorMessage): JsonResponseAlias
    {
        return $this->errorResponse($errorMessage , ' some think wrong , please try again ');
    }
}

