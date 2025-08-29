<?php

namespace App\Services;
use Carbon\Carbon;

class PostService{

    public function postDetails($posts)
    {
        
        return $posts->map(function($post){

            // Format the post content
            
            return [
                'post_id'=>$post->id,
                'post_content'=> $this->formatPostContent($post),
                'post_by'=>$post->user->profile->first_name,
                'posted_at'=>Carbon::parse($post->posting_date)->diffForHumans(),
                'post_image'=>$post->post_image,
                'profile_image'=>$post->user->profile->profile_image,
                'comments'=> ($post->comments) ? $this->formatCommentContent($post->comments)->toArray() : [],
            ];
        });
    }

    private function formatPostContent($post)
    {
        $content =$post->content;
        return [
            'id' => $content['id'],
            'question' => $content['question'],
            'options' => json_decode($content['options']),
            'level' => $content['difficulty_level'] ?? 'unknown',
            'answer' => $content['answer'],
            'points' => $content['points'] ?? 0,
        ];
    }

    private function formatCommentContent($comments)
    {
        $formated = $comments->map(function($comment){
            return [
                'id' => $comment->id,
                'user_id' => $comment->user_id,
                'comment' => $comment->comment,
                'is_like' => $comment->is_like,
                'created_at' => Carbon::parse($comment->created_at)->diffForHumans(),
                'profile_image' => $comment->user->profile->profile_image,
                'comment_by' => $comment->user->profile->first_name,
            ];
        });

        return $formated;
    }
}