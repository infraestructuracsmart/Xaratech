<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UsersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Auth
Route::prefix('auth')->group(function (){
    //Login
    Route::post('/login', [AuthController::class, 'login']);
});
Route::prefix('auth')->middleware('auth:api')->group(function (){
    //Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});

//Usuarios
Route::prefix('user')->middleware('auth:api')->group(function (){
    //Crear usuario
    Route::post('/', [UsersController::class, 'store']);
});
Route::prefix('users')->middleware('auth:api')->group(function (){
    //Obtener usuario
    Route::get('/', [UsersController::class, 'index']);
});