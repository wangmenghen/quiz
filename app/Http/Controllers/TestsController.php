<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Test;
use App\TestAnswer;
use App\Topic;
use App\Question;
use App\QuestionsOption;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTestRequest;
use App\QuizLog;

class TestsController extends Controller
{
    /**
     * Display a new test.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($typeId)
    {
        $questions = Question::where('topic_id', $typeId)->inRandomOrder()->limit(30)->get();
        foreach ($questions as &$question) {
            $question->options = QuestionsOption::where('question_id', $question->id)->inRandomOrder()->get();
        }

        return view('tests.create', compact('questions'));
    }

    /**
     * Store a newly solved Test in storage with results.
     *
     * @param  \App\Http\Requests\StoreResultsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = 0;
        // var_dump($request->all());
        // die();
        $test = Test::create([
            'user_id' => Auth::id(),
            'result'  => $result,
        ]);
        // var_dump($request->input());
        // die();
        // 处理单选
        foreach ($request->input('questions', []) as $key => $question) {
            $status = 0;

            if ($request->input('answers.'.$question) != null
                && QuestionsOption::find($request->input('answers.'.$question))->correct
            ) {
                $status = 1;
                $result++;
            }
            TestAnswer::create([
                'user_id'     => Auth::id(),
                'test_id'     => $test->id,
                'question_id' => $question,
                'option_id'   => $request->input('answers.'.$question),
                'correct'     => $status,
            ]);
        }

        // 处理多选
        foreach ($request->input('questionsMult', []) as $key => $question) {
            $status = [];
            $correct = 1;
            $multQuestionsOptions = QuestionsOption::find($request->input('answersMult-'.$question));
            if ($request->input('answersMult-'.$question)) {
                foreach ($request->input('answersMult-'.$question) as $ans => $answer) {
                    $status[$ans] = 0;
                    foreach ($multQuestionsOptions as $value => $multQuestionsOption) {
                        $correctMult = [];
                        if ($multQuestionsOption->correct) {
                            if ($answer != null && $multQuestionsOption->id == $answer) {
                                $status[$ans] = 1;
                            }
                        }
                    } 
                }
                foreach ($status as $index) {
                    if (!$index) $correct = 0;
                }
                if ($correct) {
                    $result++;
                }
            } else {
                $correct = 0;
            }
            // var_dump(implode(',', $request->input('answersMult-'.$question)));
            $submitOption = $request->input('answersMult-'.$question) ? implode(',', $request->input('answersMult-'.$question)) : 0;
            TestAnswer::create([
                'user_id'       => Auth::id(),
                'test_id'       => $test->id,
                'question_id'   => $question,
                'option_id'     => 0,
                'correct'       => $correct,
                'submit_option' => $submitOption
            ]);
        }

        // 处理判断题
        foreach ($request->input('questionsjudge', []) as $key => $question) {
            $status = [];
            $correct = 1;
            $judgeQuestion = Question::find($question);
            if ($judgeQuestion->judge_correct != $request->input('answersJudge-'.$question)) {
                $correct = 0;
            }
            $submitOption = $request->input('answersJudge-'.$question);
            TestAnswer::create([
                'user_id'       => Auth::id(),
                'test_id'       => $test->id,
                'question_id'   => $question,
                'option_id'     => 0,
                'correct'       => $correct,
                'submit_option' => $submitOption
            ]);
            if ($correct) {
                $result++;
            }
        }
        
        $test->update(['result' => $result]);

        $topicId = $request->input('topicId');
        $quizlog = QuizLog::where('topics_id', $topicId)->where('user_id', Auth::id())->first();
        // var_dump($quizlog);
        // var_dump($request->input('topicId'));
        // die();
        if ($quizlog instanceof QuizLog) {
            $quizlog->is_finish = 1;
            $quizlog->save();
        }
        return redirect()->route('results.show', [$test->id]);
    }
    
    public function testIndex($typeId)
    {   
        $topic = Topic::where('id', $typeId)->first();
        // var_dump($topic);
        // die();
        $title = $topic->title;
        
        $questions = Question::where('topic_id', $typeId)->inRandomOrder()->limit(30)->get();
        $topicId = $typeId;
        foreach ($questions as &$question) {
            $question->options = QuestionsOption::where('question_id', $question->id)->inRandomOrder()->get();
        }
        $quizTime = $topic->quiz_time;
        $startTime = $topic->start_time;
        return view('tests.create', compact('questions', 'title', 'topicId', 'quizTime', 'startTime'));
    }

    public function saveTime(Request $request)
    {
        var_dump($request->input('min'));
        var_dump($request->input('sec'));
    }
}
