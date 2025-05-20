<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\ChnagePasswordRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{

    public function __construct()
    {
       $this->userService = new \App\Services\UserService();
    }
    public function userRegister(RegisterRequest $request){
        $user = $this->userService->registerUser($request->validated());
        return $user;
    }

    public function verifyEmail(Request $request){ 
        $user = $this->userService->verifyEmail($request->token);
    }
    public function userLogin(LoginRequest $request){
        $user = $this->userService->loginUser($request->validated());
        return $user;
    }

    public function passwordResetLink(PasswordResetRequest $request){
        $user = $this->userService->passwordResetLink($request->validated());
        return $user;
    }

    public function passwordReset(ChnagePasswordRequest $request, $token){
        $user = $this->userService->passwordReset($request->validated(), $token);
        return $user;
    }
}
