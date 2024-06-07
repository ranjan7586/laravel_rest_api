<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\EmployeRoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/v1/register',[UserController::class,'store']);
Route::post('/v1/login',[AuthController::class,'login']);


Route::group(['middleware' => 'check.token','prefix'=>'v1'],function($router){
    Route::get('/users',[UserController::class,'show']);
    Route::get('/profiles',[ProfileController::class,'show']);
    Route::get('/authors',[AuthorController::class,'show']);
    Route::get('/employees',[EmployeController::class,'show']);
    Route::get('/roles',[RoleController::class,'show']);
    Route::post('/create-profile',[ProfileController::class,'store']);
    Route::post('/create-employee',[EmployeController::class,'store']);
    Route::post('/employe-role',[EmployeRoleController::class,'store']);
    Route::post('/create-role',[RoleController::class,'store']);
    Route::patch('/profile-update/{id}',[UserController::class,'update']);
    Route::get('/auth-check',[AuthController::class,'authCheck']);
});