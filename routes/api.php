<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/login',[UserController::class,"login"]);
Route::post("/register", [UserController::class, "register"]);
Route::get('/getUsers', [UserController::class, 'getUsers']);