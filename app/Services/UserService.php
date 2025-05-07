<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserService{

    public function registerUser($user){
        try{
            $user = User::create($user);
            if(!$user) {
                throw new \Exception('User registration failed');
            }
            return response()->json([
                'code' => 200,
                'status' => true,
                'message' => 'User registered successfully',
            ], 200);
        }catch(\Exception $e){
            log::error('UserService @registerUser: '.$e->getMessage());
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => 'User registration failed',
            ], 500);
        }
    }
}