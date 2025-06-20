<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['first_name', 'last_name', 'gender', 'profession_id','user_id','brith_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
