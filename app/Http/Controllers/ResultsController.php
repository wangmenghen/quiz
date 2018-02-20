<?php

namespace App\Http\Controllers;

use Auth;
use App\Test;
use App\TestAnswer;
use Illuminate\Http\Request;
use App\Http\Requests\StoreResultsRequest;
use App\Http\Requests\UpdateResultsRequest;

class ResultsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except('index', 'show');
    }

    /**
     * Display a listing of Result.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Test::all()->load('user');

        if (!Auth::user()->isAdmin()) {
            $results = $results->where('user_id', '=', Auth::id());
        }

        return view('results.index', compact('results'));
    }

    /**
     * Display Result.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $test = Test::find($id)->load('user');

        if ($test) {
            $results = TestAnswer::where('test_id', $id)
                ->with('question')
                ->with('question.options')
                ->get();
        }
        foreach ($results as $key => $result) {
            if ($result->question->type == 2) {
                $submits = explode(",", $result->submit_option);
                $options = $result->question->options;
                foreach ($options as $index => $option) {
                    foreach ($submits as $submit) {
                        if ($submit == $option->id) {
                            $results[$key]->question->options[$index]['submit'] = 1;
                        }
                    }
                }
            }
        }
        return view('results.show', compact('test', 'results'));
    }
}
