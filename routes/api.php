<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

//Open Routes
Route::post("register", [UserController::class, "register"]);
Route::post("register", [UserController::class, "login"]);

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api'); */
