<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Score;

class WorkExperiance extends Model
{
    protected $fillable =['title','company','currently_working','location','selectEmpType','locationType'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function scores()
    {
        return $this->morphMany(Score::class, 'activity');
    }
    
}
