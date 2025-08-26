<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use App\Models\Answer;
use App\Models\Post;
use Carbon\Carbon;
use App\Http\Requests\AnswerRequest;

class QuestionController extends Controller
{

    public function setUserAnswer(AnswerRequest $request)
    {

        
        $user = Auth::user();

        $question = Question::where('id', $request->question_id)->first();

        // Assuming you have a method to save the user's answer

        Answer::create([
            'user_id' => $user->id,
            'question_id' => $request->question_id,
            'answer' => $request->answer,
            'answer_status' => ($question->answer == $request->answer) ? 'correct' : 'incorrect',
        ]);

        // $answer = "Correct Answer is: ".$question->answer;

        // $format_question = [
        //     'id' => $question->id,
        //     'question' => $question->question,
        //     'answer' => $answer,
        //     'options' => $question->options,
        // ];

        // $content = json_encode($format_question);
        // $post = Post::create([
        //     'user_id' => $user->id,
        //     'content' => $content,
        //     'posting_date'=>Carbon::now(),
        // ]);


        // $decode_options = json_decode($question->options, true);
        // $decode_question = json_decode($question->question, true);
        // $decode_post = json_decode($post, true);


        return response()->json(['message' => 'Answer will publish tommorrow'], 200);
    }

}
