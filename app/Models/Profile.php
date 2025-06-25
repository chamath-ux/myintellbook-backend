<?php

namespace App\Models;
use App\Models\User;
use App\Models\Post;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['first_name', 'last_name', 'gender', 'profession_id','user_id','brith_date','profile_image','cover_image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function posts()
    {
        return $this->hasMany(Post::class);
    }

}
