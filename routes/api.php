<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::apiResource('users',UserController::class);
Route::apiResource('category',CategoryController::class);
Route::apiResource('product',ProductController::class);

//Route::post('s',function (StoreProductRequest $request){
//    // Validate the incoming request data
//    $validatedData = $request->validated();
//
//    // Create a new product using the validated data
//    $product = Product::create($validatedData);
//});


Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout']);
Route::get('/me', [AuthController::class,'me']);
