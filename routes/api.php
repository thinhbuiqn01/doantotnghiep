<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\HireController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TechnologyController;
use App\Http\Controllers\UserController;
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
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::post('/create-account-school', [AuthController::class, 'createAccountSchool']);
Route::post('/users', [AuthController::class, 'index']);
Route::post('/students/{role}', [AuthController::class, 'students']);
Route::post('/user/edit/{id}', [AuthController::class, 'update']);
Route::post('/admin/user/{id}/update', [UserController::class, 'update']);
Route::get('/admin/user/{id}', [UserController::class, 'show']);
Route::post('/create-list-user', [AuthController::class, 'insertList']);


Route::get('inform/{id}', [AuthController::class, 'getInform']);

Route::get('inform-job-school', [NotificationController::class, 'informJobSchool']);

Route::post('create-informs', [NotificationController::class, 'storeInforms']);
Route::post('create-inform', [NotificationController::class, 'storeInform']);
Route::delete('delete-inform/{id}', [NotificationController::class, 'destroy']);
Route::get('get-info/{id}', [AuthController::class, 'getInfo']);

Route::post('create-inform-job-school', [NotificationController::class, 'storeInformJob']);



Route::post('extra-info-image/{id}', [BusinessController::class, 'storeImage']);
Route::post('extra-info', [BusinessController::class, 'store']);
Route::post('account-close/{id}', [AuthController::class, 'closeAccount']);
Route::post('account-open/{id}', [AuthController::class, 'openAccount']);


/* Technology */
Route::get('technologies', [TechnologyController::class, 'index']);
Route::get('technologies/{id}', [TechnologyController::class, 'show']);
Route::post('technologies/update/{id}', [TechnologyController::class, 'update']);
Route::post('technologies/create', [TechnologyController::class, 'store']);
Route::post('technologies/image-store/{id}', [TechnologyController::class, 'storeImage']);


/* Business */

Route::get('business/{id}', [AuthController::class, 'getBusiness']);
Route::post('give-job', [JobController::class, 'store']);
Route::get('business-hot', [BusinessController::class, 'bsnHot']);
Route::get('business-job/{id}', [BusinessController::class, 'allInformation']);


/* Jobs*/
Route::get('job/{id}', [JobController::class, 'jobInfo']);
Route::get('jobs/{id}', [JobController::class, 'show']);
Route::post('job-edit/{id}', [JobController::class, 'update']);
Route::post('/jobs-hot', [JobController::class, 'jobHot']);
Route::get('jobs-full', [JobController::class, 'jobFull']);

Route::get('jobs', [JobController::class, 'index']);
Route::get('job-by-id-business/{id}', [JobController::class, 'jobByBusiness']);
Route::post('/admin/user/delete/{id}', [UserController::class, 'deleteUser']);
Route::get('jobs-confirm', [JobController::class, 'jobsConfirm']);
Route::post('job-status-edit/{idJob}', [JobController::class, 'editStatusJob']);
Route::post('job-delete-inform', [JobController::class, 'deleteInform']);

Route::get('/admin/businesses', [BusinessController::class, 'index']);


Route::get('address/local', [AddressController::class, 'index']);

/* Hire */

Route::post('hire/upload', [HireController::class, 'store']);
Route::post('hire/upload/cv/{id}', [HireController::class, 'updateCV']);
Route::get('hire', [HireController::class, 'index']);
