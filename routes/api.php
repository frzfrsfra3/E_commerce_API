<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
   
// });
// Route::middleware('auth:api')->group(function () {
//     Route::resource('products', 'ProductController');
//     Route::post('register', 'AuthController@register');
//     Route::post('login', 'AuthController@login');
//     Route::get('user', 'AuthController@getAuthenticatedUser')->middleware('auth:api');
//     Route::resource('orders', 'OrderController')->only(['store']);
// });
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::resource('products', ProductController::class);
    Route::post('orders', [OrderController::class, 'store']);
});
