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

class TestsController extends Controller
{
    /**
     * Display a new test.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($typeId)
    {
        // $topics = Topic::inRandomOrder()->limit(10)->get();

        // $questions = Question::inRandomOrder()->limit(10)->get();

        $questions = Question::where('topic_id', $typeId)->inRandomOrder()->limit(30)->get();
        foreach ($questions as &$question) {
            $question->options = QuestionsOption::where('question_id', $question->id)->inRandomOrder()->get();
        }

        /*
        foreach ($topics as $topic) {
            if ($topic->questions->count()) {
                $questions[$topic->id]['topic'] = $topic->title;
                $questions[$topic->id]['questions'] = $topic->questions()->inRandomOrder()->first()->load('options')->toArray();
                shuffle($questions[$topic->id]['questions']['options']);
            }
        }
        */

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
        
        $test->update(['result' => $result]);

        return redirect()->route('results.show', [$test->id]);
    }
    
    public function testIndex($typeId)
    {
        // var_dump($typeId);
        // die();
        $topic = Topic::where('id', $typeId)->first();
        $title = $topic->title;
        $questions = Question::where('topic_id', $typeId)->inRandomOrder()->limit(10)->get();
        foreach ($questions as &$question) {
            $question->options = QuestionsOption::where('question_id', $question->id)->inRandomOrder()->get();
        }

        return view('tests.create', compact('questions', 'title'));
    }

    public function saveTime(Request $request)
    {
        var_dump($request->input('min'));
        var_dump($request->input('sec'));
    }
}
