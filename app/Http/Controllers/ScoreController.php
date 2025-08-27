<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Score;
use App\Models\Post;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Notifications\NewUserNotification;


class ScoreController extends Controller
{
    private $scoreService;

    public function __construct()
    {
        $this->scoreService = new \App\Services\ScoreService();
    }

    public function getScores(Request $request)
    {
        // Logic to retrieve scores for the authenticated user
        $user = auth()->id();
        $today = Carbon::today()->toDateString();

        $scores = Score::where('user_id',$user)->with('activity')->get();

        $formatedScore = $scores->groupBy('base_type');

        $formatedScores = [
            'daily_questions'=>$formatedScore->get(0,collect())->map(function($score)use($today){


               return [
                    'id' => $score->id,
                    'activity_id' => $score->activity_id,
                    'question' => Question::where('id',$score->activity_id)->first()->question,
                    'activity_type' => $score->activity_type,
                    'question_date'=>Post::where('question_id',$score->activity_id)
                                    ->where('user_id',auth()->id())
                                    ->whereDate('posting_date','<',$today)
                                    ->first()
                                    ->posting_date,
                    'points' => $score->points,
                    'daily_total'=>Score::where('base_type',0)->sum('points'),
                    
               ];
            }),
            'profile_update'=>$formatedScore->get(1,collect())->map(function($score){


                if($score->activity_type == 'App\Models\Education'){
                    $name= "Education";
                }else if($score->activity_type == 'App\Models\WorkExperiance'){
                    $name="Experiance";
                }else if($score->activity_type == 'App\Models\Skill'){
                    $name="Skill";
                }
               return [
                    'id' => $score->id,
                    'activity_id' => $score->activity_id,
                    'added_date'=>$score->date,
                    'name' => $name,
                    'activity_type' => $score->activity_type,
                    'points' => $score->points,
                    'profile_total'=>Score::where('base_type',1)->sum('points')
               ];
            }),
            'totalScore'=> Score::where('user_id',$user)->sum('points')
        ];

        return response()->json(['data'=>$formatedScores,'code'=>200]);
    }

    public function topScores(){

        
    $scores = $this->scoreService->getTopScores();            
    $top_users=$scores->map(function($score){

        return[
            'name'=>($score['user']['profile']) ? $score['user']['profile']->first_name . ' ' .$score['user']['profile']->last_name : '',
            'profile_image'=>($score['user']['profile']) ? $score['user']['profile']->profile_image: '',
            'score'=>$score->total_points
        ];
    });

        return response()->json(['data'=>$top_users,'code'=>200]);
    }
}
