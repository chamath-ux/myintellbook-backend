<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class WorkExperiance extends Model
{
    protected $fillable =['title','company','currently_working','location','selectEmpType','locationType'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
