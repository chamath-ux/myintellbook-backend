<?php

namespace App\Services;
use App\Models\Profile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ProfileService
{
    public function insertProfile($request)
    {
        try{
            $profile=new Profile();

            $profile->first_name= $request['first_name'];
            $profile->last_name= $request['last_name'];
            $profile->gender= $request['gender'];
            $profile->profession_id= $request['profession_id'];
            $profile->user_id = Auth::user()->id;
            $profile->save();

            if(!$profile){
                throw new \Exception('Profile not created');
            }

            return response()->json([
                'code' => 200,
                'status' => true,
                'data' => 'Profile created successfully',
            ], 200);
        }catch(\Exception $e){
            log::error('CategoryService @getCategories: '.$e->getMessage());
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}