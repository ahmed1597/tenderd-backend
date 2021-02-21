<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DocumentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
/** User Routes */
Route::middleware('auth:api')->get('user/list/{id?}',[UserController::class,"list"]);
Route::middleware('auth:api')->get('user/requests/{id}',[UserController::class,"requests"]);
Route::post('user/add',[UserController::class,"add"]);
Route::middleware('auth:api')->put('user/edit',[UserController::class,"edit"]);

/** Company Routes */
Route::middleware('auth:api')->get('company/list/{id?}',[CompanyController::class,"list"]);
Route::middleware('auth:api')->get('company/users/{id}',[CompanyController::class,"users"]);
Route::middleware('auth:api')->get('company/requests/{id}',[CompanyController::class,"requests"]);
Route::middleware('auth:api')->put('company/edit',[CompanyController::class,"edit"]);

/** Request Routes */
Route::middleware('auth:api')->get('request/list/{id?}',[TicketController::class,"list"]);
Route::middleware('auth:api')->post('request/add',[TicketController::class,"add"]);
Route::middleware('auth:api')->put('request/edit',[TicketController::class,"edit"]);
Route::middleware('auth:api')->get('request/history/{id?}',[TicketController::class,"history"]);
Route::middleware('auth:api')->get('request/documents/{id?}',[TicketController::class,"documents"]);

/** Document Routes */
Route::middleware('auth:api')->post('document/add',[DocumentController::class,"add"]);