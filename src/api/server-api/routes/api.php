<?php

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
Route::apiResource('user', \App\Http\Controllers\UserController::class);
Route::post('register',[\App\Http\Controllers\UserController::class, 'register']);
Route::post('login',[\App\Http\Controllers\UserController::class, 'login']);
Route::post('logout',[\App\Http\Controllers\UserController::class, 'logout']);
Route::post('favorite/{id}/{postId}',[\App\Http\Controllers\UserController::class, 'favorite']);

Route::apiResource('teacher', \App\Http\Controllers\TeacherController::class);
Route::apiResource('post', \App\Http\Controllers\PostController::class);
Route::apiResource('category', \App\Http\Controllers\CategoryController::class);
Route::apiResource('course', \App\Http\Controllers\CourceController::class);
Route::apiResource('document', \App\Http\Controllers\DocumentController::class);
Route::apiResource('teacher{id}/cource', \App\Http\Controllers\CourceTeacherController::class);



