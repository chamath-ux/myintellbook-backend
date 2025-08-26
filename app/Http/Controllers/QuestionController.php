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
use App\Notifications\NewUserNotification;

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
        auth()->user()->notify(new NewUserNotification("You have answer the today question! answer will be publish tommorrow"));

        return response()->json(['message' => 'Answer will publish tommorrow'], 200);
    }

}
