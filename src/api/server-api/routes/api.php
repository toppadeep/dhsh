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
Route::get('index',[\App\Http\Controllers\UserController::class, 'index']);
Route::post('store',[\App\Http\Controllers\UserController::class, 'store']);
Route::post('login',[\App\Http\Controllers\UserController::class, 'login']);
Route::post('logout',[\App\Http\Controllers\UserController::class, 'logout']);

Route::apiResource('teacher', \App\Http\Controllers\TeacherController::class);
Route::get('teacherCount', [ \App\Http\Controllers\TeacherController::class, 'teacherCount' ]);
Route::get('showCource/{id}', [\App\Http\Controllers\TeacherController::class, 'showCource']);

Route::apiResource('post', \App\Http\Controllers\PostController::class);
Route::get('postCount', [ \App\Http\Controllers\PostController::class, 'postCount' ]);
Route::post('viewed', [\App\Http\Controllers\PostController::class, 'counterViewed']);
Route::apiResource('category', \App\Http\Controllers\CategoryController::class);
Route::get('categoryCount', [ \App\Http\Controllers\CategoryController::class, 'categoryCount' ]);
Route::apiResource('cource', \App\Http\Controllers\CourceController::class);
Route::get('courceCount', [ \App\Http\Controllers\CourceController::class, 'courceCount' ]);
Route::apiResource('document', \App\Http\Controllers\DocumentController::class);
Route::get('documentCount', [ \App\Http\Controllers\DocumentController::class, 'documentCount' ]);
Route::apiResource('teacher{id}/cource', \App\Http\Controllers\CourceTeacherController::class);
