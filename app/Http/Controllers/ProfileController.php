<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->profileService = new \App\Services\ProfileService();
    }
    public function insert(ProfileRequest $request){
            $profile = $this->profileService->insertProfile($request->validated());
            return $profile;
    }

    public function userData(Request $request)
    {
        $user = $this->profileService->getUserData($request->user()->id);
        return $user;
    }
}
