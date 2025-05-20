<?php

use Illuminate\Support\Facades\Route;

Route::post('/register', [\App\Http\Controllers\UserController::class, 'userRegister']);
Route::post('/verify-email', [\App\Http\Controllers\UserController::class, 'verifyEmail']);
Route::post('/login', [\App\Http\Controllers\UserController::class, 'userLogin']);
Route::post('/password/reset', [\App\Http\Controllers\UserController::class, 'passwordResetLink']);
Route::post('/password/reset/{token}', [\App\Http\Controllers\UserController::class, 'passwordReset']);
 