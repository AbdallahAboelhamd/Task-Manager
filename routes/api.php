<?php

use App\Http\Controllers\Api\V1\Authcontroller;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('projects', ProjectController::class);
Route::apiResource('tasks', TaskController::class);

Route::middleware(['auth:sanctum'])->group(function () {
    //
});

Route::get('/login' , [Authcontroller::class , 'login']);