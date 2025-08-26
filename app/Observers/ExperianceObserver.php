<?php

namespace App\Observers;

use App\Models\WorkExperiance;
use App\Models\Score;

class ExperianceObserver
{
    /**
     * Handle the WorkExperiance "created" event.
     */
    public function created(WorkExperiance $workExperiance): void
    {
            Score::create([
                'user_id' => auth()->id(), // Assuming the user is authenticated
                'activity_id' => $workExperiance->id,
                'activity_type' => get_class($workExperiance),
                'base_type'=>1,
                'points' => 1, // Initialize with a default score
            ]);
       
    }

    /**
     * Handle the WorkExperiance "updated" event.
     */
    public function updated(WorkExperiance $workExperiance): void
    {
        //
    }

    /**
     * Handle the WorkExperiance "deleted" event.
     */
    public function deleted(WorkExperiance $workExperiance): void
    {
        //
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
