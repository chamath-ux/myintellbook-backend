<?php

namespace App\Services;
use App\Models\Profile;
use App\Models\WorkExperiance;
use App\Models\Education;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProfileService
{
    public function insertProfile($request)
    {
        try{
            $profile=new Profile();

            $profile->first_name= $request['first_name'];
            $profile->last_name= $request['last_name'];
            $profile->gender= $request['gender'];
            $profile->birth_date = $request['birth_date'];
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

    public function getUserData($user_id){
        try{
            $user = Profile::where('user_id', $user_id)->first();
            return response()->json([
                'code' => 200,
                'status' => true,
                'data' => $user,
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

    public function editGeneralInfo($request)
    {
        try{
             
            $user = Profile::where('user_id',Auth::user()->id)->update([
                'first_name'=>$request['first_name'],
                'last_name'=>$request['last_name'],
                'gender'=>$request['gender'],
                'birth_date'=>$request['birth_date']
            ]);

            if(!$user){
                throw new \Exception('Data not inserted corrrectly');
            }
            return response()->json([
                'code' => 200,
                'status' => true,
                'data' => 'General Info Edit successfull',
            ], 200);

        }catch(\Exception $e)
        {
              log::error('ProfileService @editGeneralInfo: '.$e->getMessage());
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getGeneralInfo()
    {
        try{
            $info = Profile::where('user_id',Auth::user()->id)->get();

            if(!$info)
            {
                throw new \Exception('general info not getting');
            }
             return response()->json([
                'code' => 200,
                'status' => true,
                'data'=>$info,
            ], 200);

        }catch(\Exception $e){
            log::error('ProfileService @editGeneralInfo: '.$e->getMessage());
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function addWorkExperiance($request)
    {
        try{
            $work = new WorkExperiance();
            $work->title = $request['title'];
            $work->company = $request['company'];
            $work->currently_working = $request['currently_working'];
            $work->location = $request['location'];
            $work->selectEmpType = $request['selectEmpType'];
            $work->locationType = $request['locationType'];
            $work->user_id = Auth::user()->id;
            $work->save();

            if(!$work)
            {
                throw new \Exception('work experiance not inserted correctly');
            }
             return response()->json([
                'code' => 200,
                'status' => true,
                'data'=>'work experiance inserted successfully',
            ], 200);
        }catch(\Exception $e){
             log::error('ProfileService @addWorkExperiance: '.$e->getMessage());
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getExperiances(){
        try{

            $experiance = WorkExperiance::where('user_id',Auth::user()->id)->get();

            if(!$experiance)
            {
                throw new \Exception('work experiance not get correctly');
            }
             return response()->json([
                'code' => 200,
                'status' => true,
                'data'=>$experiance,
            ], 200);

        }catch(\Exception $e){
            log::error('ProfileService @getExperiances: '.$e->getMessage());
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getExperianceDetails($id)
    {
         try{

            $experiance = WorkExperiance::where('id',$id)->where('user_id',Auth::user()->id)->get();

            if(!$experiance)
            {
                throw new \Exception('work experiance not get correctly');
            }
            if(count($experiance) == 0)
            {
                throw new \Exception('You have no authorized');
            }
             return response()->json([
                'code' => 200,
                'status' => true,
                'data'=>$experiance,
            ], 200);

        }catch(\Exception $e){
            log::error('ProfileService @getExperiances: '.$e->getMessage());
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function editExperianceDetails($id,$request)
    {
         try{

            $experiance = WorkExperiance::find($id);

            $experiance->title = $request['title'];
            $experiance->company = $request['company'];
            $experiance->currently_working = $request['currently_working'];
            $experiance->location = $request['location'];
            $experiance->selectEmpType = $request['selectEmpType'];
            $experiance->locationType = $request['locationType'];
            $experiance->update();
            
            if($experiance->currently_working == 1)
            {
                
            }

            if(!$experiance)
            {
                throw new \Exception('work experiance not edit correctly');
            }
             return response()->json([
                'code' => 200,
                'status' => true,
                'data'=>'successfully updated work experiance',
            ], 200);

        }catch(\Exception $e){
            log::error('ProfileService @editExperianceDetails: '.$e->getMessage());
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteExperiance($id)
    {
        try{

            $experiance = WorkExperiance::find($id);
            $experiance->delete();

            if(!$experiance)
            {
                throw new \Exception('work experiance delete correctly');
            }
             return response()->json([
                'code' => 200,
                'status' => true,
                'data'=>'successfully deleted work experiance',
            ], 200);

        }catch(\Exception $e){
            log::error('ProfileService @deleteExperiance: '.$e->getMessage());
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function addEducation($request)
    {
        try{

            $education = new Education();
            $education->school = $request['school'];
            $education->degree = $request['degree'];
            $education->field_of_study = $request['field_of_study'];
            $education->user_id = Auth::user()->id;
            $education->save();

            return response()->json([
                'code' => 200,
                'status' => true,
                'data'=>'successfully add the education details',
            ], 200);

        }catch(\Exception $e){
            log::error('ProfileService @addEducation: '.$e->getMessage());
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getEducationDetails()
    {
         try{

            $education = Education::where('user_id',Auth::user()->id)->get();

            return response()->json([
                'code' => 200,
                'status' => true,
                'data'=>$education,
            ], 200);

        }catch(\Exception $e){
            log::error('ProfileService @getEducationDetails: '.$e->getMessage());
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getEducationDetail($id)
    {
        try{

            $education = Education::where('user_id',Auth::user()->id)->where('id',$id)->get();

            return response()->json([
                'code' => 200,
                'status' => true,
                'data'=>$education,
            ], 200);

        }catch(\Exception $e){
            log::error('ProfileService @getEducationDetails: '.$e->getMessage());
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteEducation($id)
    {
         try{

            $education = Education::where('user_id',Auth::user()->id)->where('id',$id);
            $education->delete();

            return response()->json([
                'code' => 200,
                'status' => true,
                'data'=>'successfully delete the education details',
            ], 200);

        }catch(\Exception $e){
            log::error('ProfileService @deleteEducation: '.$e->getMessage());
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}