<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\GeneralInfoRequest;
use App\Http\Requests\WorkExperianceRequest;
use App\Http\Requests\EducationRequest;
use Auth;

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
        $user = $this->profileService->getUserData(Auth::user()->id);
        return $user;
    }

    public function editGeneralInfo(GeneralInfoRequest $request)
    {
        $user = $this->profileService->editGeneralInfo($request);
        return $user;
    }

    public function gtGeneralInfo()
    {
        $user = $this->profileService->getGeneralInfo();
        return $user;
    }

    public function addWorkExperiance(WorkExperianceRequest $request)
    {
        $user = $this->profileService->addWorkExperiance($request);
        return $user;
    }

    public function getExperiances()
    {
        $user = $this->profileService->getExperiances();
        return $user;
    }

    public function getExperianceDetails($id)
    {
        $user = $this->profileService->getExperianceDetails($id);
        return $user;
    }

    public function editExperianceDetails($id, WorkExperianceRequest $request)
    {
        $user = $this->profileService->editExperianceDetails($id, $request);
        return $user;
    }

    public function deleteExperiance($id)
    {
        $user = $this->profileService->deleteExperiance($id);
        return $user;
    }

    public function addEducation(EducationRequest $request)
    {
        $user= $this->profileService->addEducation($request);
        return $user;
    } 

    public function getEducationDetails()
    {
        $user= $this->profileService->getEducationDetails();
        return $user;
    }

    public function getEducationDetail($id)
    {
        $user= $this->profileService->getEducationDetail($id);
        return $user;
    }

    public function deleteEducation($id)
    {
        $user = $this->profileService->deleteEducation($id);
        return $user;
    }
}
