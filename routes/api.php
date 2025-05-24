<?php

use Illuminate\Support\Facades\Route;

Route::post('/register', [\App\Http\Controllers\UserController::class, 'userRegister']);
Route::post('/verify-email', [\App\Http\Controllers\UserController::class, 'verifyEmail']);
Route::post('/login', [\App\Http\Controllers\UserController::class, 'userLogin']);
Route::post('/password/reset', [\App\Http\Controllers\UserController::class, 'passwordResetLink']);
Route::post('/password/reset/{token}', [\App\Http\Controllers\UserController::class, 'passwordReset']);

Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'getCategories']);
Route::get('/professions/{category_id}',[\App\Http\Controllers\CategoryController::class, 'getProfessions']);
Route::post('/insert-profile',[\App\Http\Controllers\ProfileController::class, 'insert']);
 