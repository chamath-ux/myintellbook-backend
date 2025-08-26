<?php

namespace App\Observers;

use App\Models\Skill;
use App\Models\Score;

class SkillObserver
{
    /**
     * Handle the Skill "created" event.
     */
    public function created(Skill $skill): void
    {
            Score::create([
                'user_id' => auth()->id(), // Assuming the user is authenticated
                'activity_id' => $skill->id,
                'activity_type' => get_class($skill),
                'base_type'=>1,
                'points' => 1, // Initialize with a default score
            ]);
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
        //
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
