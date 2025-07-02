<?php

use Illuminate\Support\Facades\Route;

Route::post('/register', [\App\Http\Controllers\UserController::class, 'userRegister']);
Route::post('/verify-email', [\App\Http\Controllers\UserController::class, 'verifyEmail']);
Route::post('/login', [\App\Http\Controllers\UserController::class, 'userLogin']);
Route::post('/password/reset', [\App\Http\Controllers\UserController::class, 'passwordResetLink']);
Route::post('/password/reset/{token}', [\App\Http\Controllers\UserController::class, 'passwordReset']);


 

 
Route::middleware('auth.token')->group(function () {
    Route::get('/user', [\App\Http\Controllers\UserController::class, 'userCheck']);
    Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'getCategories']); 
    Route::get('/professions/{category_id}',[\App\Http\Controllers\CategoryController::class, 'getProfessions']);
    Route::post('/insert-profile',[\App\Http\Controllers\ProfileController::class, 'insert']);
    Route::get('/user-data', [\App\Http\Controllers\ProfileController::class, 'userData']);
    Route::post('/edit-general-info',[\App\Http\Controllers\ProfileController::class,'editGeneralInfo']);
    Route::get('/log-out',[\App\Http\Controllers\UserController::class, 'logOut']);
    Route::get('/get-general-info',[\App\Http\Controllers\ProfileController::class,'gtGeneralInfo']);
    Route::post('/add-work-experiance',[\App\Http\Controllers\ProfileController::class,'addWorkExperiance']);
    Route::get('/get-work-experiances',[\App\Http\Controllers\ProfileController::class, 'getExperiances']);
    Route::get('/get-details-experiance/{id}',[\App\Http\Controllers\ProfileController::class,'getExperianceDetails']);
    Route::post('edit-details-experiance',[\App\Http\Controllers\ProfileController::class,'editExperianceDetails']);
    Route::get('/delete-experiance/{id}',[\App\Http\Controllers\ProfileController::class,'deleteExperiance']);
    Route::post('/add-education-details',[\App\Http\Controllers\ProfileController::class, 'addEducation']);
    Route::get('/get-education-details',[\App\Http\Controllers\ProfileController::class, 'getEducationDetails']);
    Route::get('/get-education-detail/{id}',[\App\Http\Controllers\ProfileController::class,'getEducationDetail']);
    Route::get('/delete-education/{id}',[\App\Http\Controllers\ProfileController::class,'deleteEducation']);
    Route::post('/edit-education-detail',[\App\Http\Controllers\ProfileController::class, 'editEducation']);
    Route::post('/add-skill',[\App\Http\Controllers\ProfileController::class,'addSkill']);
    Route::get('/get-skills',[\App\Http\Controllers\ProfileController::class,'getSkills']);
    Route::get('/delete-skill/{id}',[\App\Http\Controllers\ProfileController::class,'deleteSkill']);
    Route::post('/upload-profile-image',[\App\Http\Controllers\ProfileController::class,'uploadProfileImage']);
    Route::post('/upload-cover-image',[\App\Http\Controllers\ProfileController::class,'uploadCoverImage']);
    Route::get('/profile-completed-status',[\App\Http\Controllers\ProfileController::class,'checkProfileCompleted']);
    Route::get('/get-user-summary',[\App\Http\Controllers\ProfileController::class,'basicInfo']);
    Route::get('/profile-list',[\App\Http\Controllers\ProfileController::class,'profileList']);
});
