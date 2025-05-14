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
            $user->generateVerificationToken();
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

    public function verifyEmail($token){
        try{
            $user = User::where('email_verification_token', $token)->first();
            if(!$user) {
                throw new \Exception('Invalid token');
            }
            $user->email_verified_at = now();
            $user->email_verification_token = null;
            $user->save();
            return response()->json([
                'code' => 200,
                'status' => true,
                'message' => 'Email verified successfully',
            ], 200);
        }catch(\Exception $e){
            log::error('UserService @verifyEmail: '.$e->getMessage());
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => 'Email verification failed',
            ], 500);
        }
    }
}