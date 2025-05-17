<?php

use Illuminate\Support\Facades\Route;

Route::post('/register', [\App\Http\Controllers\UserController::class, 'userRegister']);
Route::post('/login', [\App\Http\Controllers\UserController::class, 'userLogin']);