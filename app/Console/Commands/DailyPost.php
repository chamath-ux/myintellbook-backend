<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Support\Facades\Log;
use App\Models\Post;
use App\Models\Score;
class DailyPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:daily-post';

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
        $yesterday = Carbon::yesterday()->toDateString();

        $users = \App\Models\User::get();

        foreach ($users as $key => $user) {
            
            
            $getYesterDayQuestion = Question::where('user_id',$user->id)
                                        ->whereDate('issue_date',$yesterday)
                                        ->first();


            if($getYesterDayQuestion){
                $answer = Answer::where('user_id', $user->id)
                ->latest('id')
                ->first();

                if (!$answer) {
                    $this->error('No answer found for user ID: ' . $user->id);
                    
                    Score::create([
                        'user_id' => $user->id,
                        'activity_id' => $getYesterDayQuestion->id,
                        'activity_type' => Question::class,
                        'points' => 0,
                        'date' => Carbon::now(),
                    ]);
                     $this->updatePost($getYesterDayQuestion, $user, ($answer) ? $answer : 'No answer',$yesterday);
                    continue;
                }

                  Score::create([
                        'user_id' => $user->id,
                        'activity_id' => $getYesterDayQuestion->id,
                        'activity_type' => Question::class,
                        'points' => ($answer->answer_status == 'correct') ? 5 : 0,
                        'date' => Carbon::now(),
                    ]);

                       $this->updatePost($getYesterDayQuestion, $user, ($answer)? $answer->status : 'No answer',$yesterday);
            }

            
        }
        Log::info('post created ran at ' . now());
        $this->info('Daily questions assigned successfully.');
    }

    private function updatePost($getYesterDayQuestion, $user, $answer,$yesterday)
    {
            $question = json_encode([
                    'id' => $getYesterDayQuestion->id,
                    'question' => $getYesterDayQuestion->question,
                    'options' => $getYesterDayQuestion->options,
                    'answer' => $getYesterDayQuestion->answer,
                    'difficulty_level' => $getYesterDayQuestion->difficulty_level,
                    'points' => Score::where('user_id', $user->id)
                        ->where('activity_id', $getYesterDayQuestion->id)
                        ->where('activity_type', Question::class)
                        ->first()->points,
                ]);

                $post = \App\Models\Post::where('user_id',$user->id)->whereDate('posting_date',$yesterday)->update([
                    'user_id' => $user->id,
                    'content' => $question,
                    'is_approved' => true,
                    
                ]);
    }
}
