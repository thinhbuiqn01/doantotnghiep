<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/users', [AuthController::class, 'index']);
Route::post('/students/{role}', [AuthController::class, 'students']);
Route::post('/user/edit/{id}', [AuthController::class, 'update']);
Route::post('/create-list-user', [AuthController::class, 'insertList']);

Route::post('/login', [AuthController::class, 'login']);
