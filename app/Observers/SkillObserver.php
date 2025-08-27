<?php

namespace App\Observers;

use App\Models\Skill;
use App\Models\Score;
use Carbon\Carbon;
use App\Notifications\NewUserNotification;

class SkillObserver
{
    /**
     * Handle the Skill "created" event.
     */
    public function created(Skill $skill): void
    {
        $scores = new  \App\Services\ScoreService();
        $date = Carbon::now();
        $scores->addScore(auth()->user(),$skill,get_class($skill),1,1,$date);
        auth()->user()->notify(new NewUserNotification("You have added a Skill! You have gain a 1 point"));
    }

    /**
     * Handle the Skill "updated" event.
     */
    public function updated(Skill $skill): void
    {
        //
    }

    /**
     * Handle the Skill "deleted" event.
     */
    public function deleted(Skill $skill): void
    {
        auth()->user()->notify(new NewUserNotification("You have Deleted a Skill!"));
    }

    /**
     * Handle the Skill "restored" event.
     */
    public function restored(Skill $skill): void
    {
        //
    }

    /**
     * Handle the Skill "force deleted" event.
     */
    public function forceDeleted(Skill $skill): void
    {
        //
    }
}
