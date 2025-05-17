<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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

    public function loginUser($user){
        try{
            if (Auth::attempt(['email' => $user['email'], 'password' => $user['password']])) {

                $token = Auth()->user()->createToken('barerToken')->plainTextToken;
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'token' => $token,
                    'message' => 'User logged in successfully',
                ], 200);
            }else{
                throw new \Exception('Invalid credentials');
            }
            
            
        }catch(\Exception $e){
            log::error('UserService @loginUser: '.$e->getMessage());
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => 'User login failed',
            ], 500);
        }
    }
}