<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Question;
use Illuminate\Support\Facades\Log;
use App\Jobs\AssignDailyQuestions;

class AssignQuestionsForUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-questions-for-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today()->toDateString();

        $users = \App\Models\User::all();

        foreach ($users as $key => $user) {

            $seenIds = $user->questionsSeen()->pluck('questions.id')->toArray();
            
            $isQuestionAssigned = Question::where('user_id',$user->id)
                                            ->whereDate('issue_date',$today)
                                            ->exists();
                                

            if($isQuestionAssigned){ 
                $isQuestionAssigned = Question::where('user_id',$user->id)
                                            ->whereDate('issue_date',$today)
                                            ->first();
                $user->questionsSeen()->attach($unusedQuestions->id);
                $this->createDailyQUestionPost($isQuestionAssigned, $user);

                continue;
            }

            $unusedQuestions = Question::whereNotIn('id', $seenIds)->inRandomOrder()->first();
          


            if($unusedQuestions){
                $unusedQuestions->update([
                    'user_id' => $user->id,
                    'issue_date' => $today,
                ]);
                $user->questionsSeen()->attach($unusedQuestions->id);
                $this->createDailyQUestionPost($unusedQuestions, $user);
            }


           

           

        }
        Log::info('AssignDailyQuestions ran at ' . now());
        $this->info('Daily questions assigned successfully.');
    }

    private function createDailyQUestionPost($questions, $user)
    {
       

        $question = json_encode([
                'id' => $questions->id,
                'question' => $questions->question,
                'options' => $questions->options,
                'answer' => $questions->answer,
                'difficulty_level' => $questions->difficulty_level,
                'points' => 0,
                'is_approved' => false,
            ]);

        $post = \App\Models\Post::create([
                'user_id' => $user->id,
                'content' => $question,
                'question_id' => $questions->id,
                'posting_date' => Carbon::now(),
            ]);
        
    }
}
