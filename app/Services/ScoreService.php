<?php

namespace App\Services;
use App\Notifications\NewUserNotification;
use App\Models\Score;
use Illuminate\Support\Facades\DB;

class ScoreService
{
    public function notification_exsists($scores,$message, $index,$user){
         
            

            $exists = $user->notifications()
            ->where('type', NewUserNotification::class)
            ->where('data->message', $message)
            ->exists();

            return $index < 4 && !$exists;
                    
    }

    public function addScore($user,$activity_id,$activity_type,$points,$base_type=0,$date)
    {
         Score::create([
                        'user_id' => $user->id,
                        'activity_id' => $activity_id->id,
                        'activity_type' => $activity_type,
                        'points' => $points,
                        'base_type'=>$base_type,
                        'date' => $date,
                    ]);

        $index = collect($this->getTopScores())->search(function ($score)use($user) {
                        return $score['user_id'] === $user->id;
                    });

        $rank =($index +1);
        $message = "Your in Top 3 ranks ,Your rank is $rank!";
        if($this->notification_exsists($this->getTopScores() ,$message, $index,$user))
        {
            
            $user->notify(new NewUserNotification($message));
        }
    }

    public function getTopScores()
    {
        return Score::with('user')->select('user_id', DB::raw('SUM(points) as total_points'))
                    ->whereHas('user.profile', function ($q) {
                        $q->whereNotNull('first_name');
                        })
                    ->groupBy('user_id')
                    ->orderBy('total_points', 'desc')
                    ->limit(6)
                    ->get();

                     
    }
}