<?php

namespace App\Services;
use App\Notifications\NewUserNotification;
class ScoreService
{
    public function notification_exsists($scores,$message, $index){
         
            

            $exists = auth()->user()->notifications()
            ->where('type', NewUserNotification::class)
            ->where('data->message', $message)
            ->exists();

            return $index < 4 && !$exists;
                    
    }

    public function addScore()
    {
         Score::create([
                        'user_id' => $user->id,
                        'activity_id' => $getYesterDayQuestion->id,
                        'activity_type' => Question::class,
                        'points' => ($answer->answer_status == 'correct') ? 5 : 0,
                        'date' => Carbon::now(),
                    ]);
    }
}