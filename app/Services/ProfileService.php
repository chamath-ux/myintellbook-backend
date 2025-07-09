<?php

namespace App\Services;
use App\Models\Profile;
use App\Models\WorkExperiance;
use App\Models\Education;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Carbon\Carbon;

class ProfileService
{

    public function __construct()
    {
        $this->postService = new \App\Services\PostService();
    }

    public function checkProfileCompleted()
    {
        $attributes = [
            'generalInfo'=>
            [
                'first_name' =>!empty(Auth::user()->profile['first_name']),
                'last_name'=>!empty(Auth::user()->profile['last_name']),
                'gender'=>!empty(Auth::user()->profile['gender']),
                'birth_date'=>!empty(Auth::user()->profile['birth_date']),
            ],
            'coverImage'=>Auth::user()->profile['cover_image'] != NULL,
            'profileImage'=>Auth::user()->profile['profile_image'] != NULL,
            'workExperiance' => WorkExperiance::where('user_id',Auth::user()->id)->exists(),
            'education'=> Education::where('user_id',Auth::user()->id)->exists(),
            'skills'=> Skill::where('user_id',Auth::user()->id)->exists(),
        ];
        return response()->json([
                'code' => 200,
                'status' => true,
                'data' => $attributes,
        ], 200);

    }

    public function basicInfo()
    {

        $profileDetails = User::with(['workExperiances' => function ($query) {
                $query->where('currently_working', 1);
        }])->where('id',Auth::user()->id)->get();

        $Details = $profileDetails->map(function($detail){
                return [
                    'first_name'=>$detail->profile['first_name'],
                    'last_name'=>$detail->profile['last_name'],
                    'profile_image'=>$detail->profile['profile_image'],
                    'cover_image'=>$detail->profile['cover_image'],
                    'currently_working'=> $detail->workExperiances->map(function($experiance){
                        return[
                            'company'=>$experiance['company'],
                            'location'=>$experiance['location']
                        ];
                    }),
                    'posts'=>$this->postService->postDetails($detail->posts)
                ];
        });
        return response()->json([
                'code' => 200,
                'status' => true,
                'data' => $Details,
            ], 200);
    }
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
            if($request['currently_working']){
                    WorkExperiance::where('currently_working',1)->update(['currently_working'=>0]);
            }

            $work = new WorkExperiance();
            $work->title = $request['title'];
            $work->company = $request['company'];
            $work->currently_working = $request['currently_working'];
            $work->location = $request['location'];
            $work->selectEmpType = $request['selectEmpType'];
            $work->locationType = $request['locationType'];
            $work->user_id = Auth::user()->id;
            $work->save();

            Post::create([
                'content'=>'New WorkExperiance added',
                'posting_date'=>Carbon::now(),
                'user_id'=>Auth::user()->id,
            ]);
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

    public function editExperianceDetails($request)
    {
         try{

            if($request['currently_working']){
                    $work = WorkExperiance::where('currently_working',1)->where('user_id',Auth::user()->id)->update(['currently_working'=>0]);
            }
            $experiance = WorkExperiance::where('id',$request['id'])->where('user_id',Auth::user()->id)->update([
                'title'=>$request['title'],
                'company'=>$request['company'],
                'currently_working'=>$request['currently_working'],
                'location'=>$request['location'],
                'selectEmpType'=>$request['selectEmpType'],
                'locationtype'=>$request['locationType']
            ]);

            Post::create([
                'content'=>'Work Experiance updated',
                'posting_date'=>Carbon::now(),
                'user_id'=>Auth::user()->id,
            ]);

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
            Post::create([
                'content'=>'WorkExperiance deleted',
                'posting_date'=>Carbon::now(),
                'user_id'=>Auth::user()->id,
            ]);
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

            Post::create([
                'content'=>'education details added',
                'posting_date'=>Carbon::now(),
                'user_id'=>Auth::user()->id,
            ]);

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

             Post::create([
                'content'=>'education details deleted',
                'posting_date'=>Carbon::now(),
                'user_id'=>Auth::user()->id,
            ]);

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

    public function editEducation($request)
    {
        try{

            $education = Education::where('user_id',Auth::user()->id)->where('id',$request['id'])->update([
                'school'=>$request['school'],
                'degree'=>$request['degree'],
                'field_of_study'=>$request['field_of_study']
            ]);

             Post::create([
                'content'=>'education details updated',
                'posting_date'=>Carbon::now(),
                'user_id'=>Auth::user()->id,
            ]);

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

    public function addSkill($request)
    {
         try{
            $education = new Skill();
            $education->skill = $request['skill'];
            $education->user_id = Auth::user()->id;
            $education->save();

             Post::create([
                'content'=>'skill details added',
                'posting_date'=>Carbon::now(),
                'user_id'=>Auth::user()->id,
            ]);

            return response()->json([
                'code' => 200,
                'status' => true,
                'data'=>'successfully Add the skill details',
            ], 200);

        }catch(\Exception $e){
            log::error('ProfileService @addSkill: '.$e->getMessage());
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getSkills()
    {
         try{
            $education = Skill::where('user_id',Auth::user()->id)->get();

            return response()->json([
                'code' => 200,
                'status' => true,
                'data'=>$education,
            ], 200);

        }catch(\Exception $e){
            log::error('ProfileService @getSkills: '.$e->getMessage());
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteSkill($id)
    {
         try{
            $education = Skill::where('id',$id)->where('user_id',Auth::user()->id);
            $education->delete();

            Post::create([
                'content'=>'skill details deleted',
                'posting_date'=>Carbon::now(),
                'user_id'=>Auth::user()->id,
            ]);

            return response()->json([
                'code' => 200,
                'status' => true,
                'data'=>'successfully deleted the skill',
            ], 200);

        }catch(\Exception $e){
            log::error('ProfileService @deleteSkill: '.$e->getMessage());
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function uploadProfileImage($request)
    {
         try{
            $education = Profile::where('user_id',Auth::user()->id)->update([
                'profile_image'=>$request['image']
            ]);
             Post::create([
                'content'=>'Profile Image changed',
                'post_image'=>$request['image'],
                'posting_date'=>Carbon::now(),
                'user_id'=>Auth::user()->id,
            ]);

            return response()->json([
                'code' => 200,
                'status' => true,
                'data'=>'successfully upload the image',
            ], 200);

        }catch(\Exception $e){
            log::error('ProfileService @uploadProfileImage: '.$e->getMessage());
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function uploadCoverImage($request)
    {
        try{
            $education = Profile::where('user_id',Auth::user()->id)->update([
                'cover_image'=>$request['image']
            ]);
            Post::create([
                'content'=>'Cover Image changed',
                'post_image'=>$request['image'],
                'posting_date'=>Carbon::now(),
                'user_id'=>Auth::user()->id,
            ]);

            return response()->json([
                'code' => 200,
                'status' => true,
                'data'=>'successfully upload the image',
            ], 200);

        }catch(\Exception $e){
            log::error('ProfileService @uploadCoverImage: '.$e->getMessage());
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function profileList()
    {
        try{

            $profileDetails = User::with(['workExperiances' => function ($query) {
                    $query->where('currently_working', 1);
            }])->whereNot('id',Auth::user()->id)->get();

        $Details = $profileDetails->map(function($detail){
                return [
                    'first_name'=>$detail->profile['first_name'],
                    'last_name'=>$detail->profile['last_name'],
                    'profile_image'=>$detail->profile['profile_image'],
                    'currently_working'=> $detail->workExperiances->map(function($experiance){
                        return[
                            'company'=>$experiance['company'],
                            'location'=>$experiance['location']
                        ];
                    }),
                ];
        });

            if(!$profileDetails)
            {
                throw new \Exception('Profiles not found');
            }

            return response()->json([
                'code' => 200,
                'status' => true,
                'data' => $Details,
            ], 200);

        }catch(\Exception $e){
            log::error('ProfileService @getProfilesList: '.$e->getMessage());
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}