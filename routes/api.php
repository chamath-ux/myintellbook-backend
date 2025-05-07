<?php

use Illuminate\Support\Facades\Route;

Route::post('/register', [\App\Http\Controllers\UserController::class, 'userRegister']);