<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Throwable as ThrowableAlias;


class UserController extends Controller
{
use APIResponseTrait;
//    public function __construct()
//    {     
//        $this->middleware('auth:api');
//    }
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $users = User::all();
            if (!$users)
                return $this->noContentResponse('there  is mo users !!!!  ');

            return $this->successResponse(['users' => UserResource::collection($users) ] , 'users returned successfully ');
        } catch (ThrowableAlias $th) {
            return $this->generalFailureResponse($th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)/*: JsonResponse*/
    {
        try {
            $validate = $request->validated();
            $user= User::create([
                'name'    =>$request->name,
                'email'   =>$request->email,
                'password'=>$request->password,
                'type'    =>$request->type,
            ]);
            return $this->createdResponse( ['user' => new UserResource($user)] , 'user ' );
        } catch (ThrowableAlias $th) {
            return $this->generalFailureResponse($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        try {
            return $this->successResponse(['user' => $user ] , 'user returned successfully ' );
        } catch (ThrowableAlias $th) {
            return $this->generalFailureResponse($th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        try {
            $validate = $request->validated();
            $user->update([
                'name'    =>$request->name     ??$user->name,
                'email'   =>$request->email    ??$user->email,
                'password'=>$request->password ??$user->password,
                'type'    =>$request->type     ??$user->type,
            ]);
            return $this->successResponse(['user ' => new UserResource($user) ] , 'user updated successfully' );
        } catch (ThrowableAlias $th) {
            return $this->generalFailureResponse($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        try {
            $user->delete();
            return $this->okResponse(['user' => $user ] , 'user  deleted successfully ');
        } catch (ThrowableAlias $th) {
            return $this->generalFailureResponse($th->getMessage());
        }
    }
}
