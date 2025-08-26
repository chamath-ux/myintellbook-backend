<?php

namespace App\Observers;

use App\Models\Education;
use App\Models\Score;
use App\Notifications\NewUserNotification;

class EducationObserver
{
    /**
     * Handle the Education "created" event.
     */
    public function created(Education $education): void
    {
       Score::create([
                'user_id' => auth()->id(), // Assuming the user is authenticated
                'activity_id' => $education->id,
                'activity_type' => get_class($education),
                'base_type'=>1,
                'points' => 1, // Initialize with a default score
            ]);
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
