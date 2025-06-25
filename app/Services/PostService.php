<?php

namespace App\Services;
use Carbon\Carbon;

class PostService{

    public function postDetails($posts)
    {
        return $posts->map(function($post){
            return [
                'post_id'=>$post->id,
                'post_content'=>$post->content,
                'post_by'=>$post->user->profile->first_name,
                'posted_at'=>Carbon::parse($post->posting_date)->diffForHumans(),
                'post_image'=>$post->post_image,
                'profile_image'=>$post->user->profile->profile_image
            ];
        });
    }
}