<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class UserController extends Controller
{
    public function userRegister(RegisterRequest $request){
        dd('ok');
    }
}
