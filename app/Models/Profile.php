<?php

namespace App\Models;
use App\Models\User;
use App\Models\Post;
use Laravel\Scout\Searchable;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use Searchable;

    protected $fillable = ['first_name', 'last_name', 'gender', 'profession_id','user_id','brith_date','profile_image','cover_image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function posts()
    {
        return $this->hasMany(Post::class);
    }

     /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        $array = [
            'first_name'=>$this->first_name
        ];
 
        // Customize the data array...
 
        return $array;
    }
}
