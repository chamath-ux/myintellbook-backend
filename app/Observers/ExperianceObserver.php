<?php

namespace App\Observers;

use App\Models\WorkExperiance;
use App\Models\Score;
use App\Notifications\NewUserNotification;
use Carbon\Carbon;

class ExperianceObserver
{
    /**
     * Handle the WorkExperiance "created" event.
     */
    public function created(WorkExperiance $workExperiance): void
    {
        $scores = new  \App\Services\ScoreService();
        $date = Carbon::now();
        $scores->addScore(auth()->user(),$workExperiance,get_class($workExperiance),1,1,$date);
        auth()->user()->notify(new NewUserNotification("Your Experiance added! You got 1 point for adding a experiance"));
       
    }

    /**
     * Handle the WorkExperiance "updated" event.
     */
    public function updated(WorkExperiance $workExperiance): void
    {
        auth()->user()->notify(new NewUserNotification("Your Experiance Updated!"));
    }

    /**
     * Handle the WorkExperiance "deleted" event.
     */
    public function deleted(WorkExperiance $workExperiance): void
    {
       auth()->user()->notify(new NewUserNotification("Your Experiance Deleted!"));
    }

    /**
     * Handle the WorkExperiance "restored" event.
     */
    public function restored(WorkExperiance $workExperiance): void
    {
        //
    }

    /**
     * Handle the WorkExperiance "force deleted" event.
     */
    public function forceDeleted(WorkExperiance $workExperiance): void
    {
        //
    }
}
