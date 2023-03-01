<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\NotificationController;
use App\Models\User;
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

/* Route::get('1-m', function () {
    $data = User::find(1)->notifications->toArray();
    dd($data);
}); */

Route::get('inform/{id}', [AuthController::class, 'getInform']);

Route::post('create-informs', [NotificationController::class, 'storeInforms']);
Route::post('create-inform', [NotificationController::class, 'storeInform']);
Route::delete('delete-inform/{id}', [NotificationController::class, 'destroy']);
Route::get('get-info/{id}', [AuthController::class, 'getInfo']);

Route::post('extra-info', [BusinessController::class, 'store']);
Route::post('account-close/{id}', [AuthController::class, 'closeAccount']);
Route::post('account-open/{id}', [AuthController::class, 'openAccount']);
