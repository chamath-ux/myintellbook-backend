<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
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

    public function userLogin(LoginRequest $request){
        $user = $this->userService->loginUser($request->validated());
        return $user;
    }
}
