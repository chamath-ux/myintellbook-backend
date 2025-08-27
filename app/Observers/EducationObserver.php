<?php

namespace App\Observers;

use App\Models\Education;
use App\Models\Score;
use App\Notifications\NewUserNotification;
use Carbon\Carbon;

class EducationObserver
{
    /**
     * Handle the Education "created" event.
     */
    public function created(Education $education): void
    {
        $scores = new  \App\Services\ScoreService();
        $date = Carbon::now();
        $scores->addScore(auth()->user(),$education,get_class($education),1,1,$date);
        auth()->user()->notify(new NewUserNotification("You have added a Education detail! You have gain a 1 point"));
    }

    /**
     * Handle the Education "updated" event.
     */
    public function updated(Education $education): void
    {
        //
    }

    /**
     * Handle the Education "deleted" event.
     */
    public function deleted(Education $education): void
    {
         auth()->user()->notify(new NewUserNotification("You have Deleted a Education detail!"));
    }

    /**
     * Handle the Education "restored" event.
     */
    public function restored(Education $education): void
    {
        //
    }

    /**
     * Handle the Education "force deleted" event.
     */
    public function forceDeleted(Education $education): void
    {
        //
    }
}
