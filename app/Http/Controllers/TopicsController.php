<?php

namespace App\Http\Controllers;

use App\Topic;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTopicsRequest;
use App\Http\Requests\UpdateTopicsRequest;
use App\User;
use App\QuizLog;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of Topic.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = Topic::all();
        
        return view('topics.index', compact('topics'));
    }

    /**
     * Show the form for creating new Topic.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('topics.create', compact('users'));
    }

    /**
     * Store a newly created Topic in storage.
     *
     * @param  \App\Http\Requests\StoreTopicsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTopicsRequest $request)
    {
        // var_dump($request->all());
        // die();
        $topic = Topic::create([
            'title'       => $request->input('title'),
            'quiz_time'   => $request->input('quizTime'),
            'start_time'  => $request->input('startTime'),
            // ''  => $request->input(),
        ]);
        $testers = $request->input('tester');
        foreach ($testers as $tester) {
            $quizLog = QuizLog::where('user_id', $tester)->where('topics_id', $topic->id)->first();
            $user = User::where('id', $tester)->first();
            if (!($quizLog instanceof QuizLog)) {
                QuizLog::create([
                    'user_id'   => $tester,
                    'topics_id' => $topic->id,
                    'is_finish' => 0,
                    'title'     => $request->input('title'),
                    'username'  => $user->name,
                ]);
            }
        }
        return redirect()->route('topics.index');
    }


    /**
     * Show the form for editing Topic.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $topic = Topic::findOrFail($id);
        // var_dump($topic);
        // $quizLogs = Quizlog::all();
        $users = User::all();
        foreach ($users as $key => $user) {
            $quizLog = QuizLog::where('user_id', $user->id)->where('topics_id', $id)->first();
            if ($quizLog instanceof QuizLog) {
                $users[$key]['join'] = 1;
            } else {
                $users[$key]['join'] = 0;
            }
        }
        $role = Auth::user()->role_id;
        $topicId = $id;
        return view('topics.edit', compact('topic', 'users', 'role', 'topicId'));
    }

    /**
     * Update Topic in storage.
     *
     * @param  \App\Http\Requests\UpdateTopicsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTopicsRequest $request, $id)
    {
        $topic = Topic::findOrFail($id);
        $topic->title = $request->input('title');
        $topic->quiz_time = $request->input('quizTime');
        $topic->start_time = $request->input('startTime');
        $topic->save();

        $testers = $request->input('tester');
        // 新增的考试者     
        if ($testers) {
            foreach ($testers as $tester) {
                $quizLog = QuizLog::where('user_id', intval($tester))->where('topics_id', $id)->first();
                $user = User::where('id', intval($tester))->first();
                if (!($quizLog instanceof QuizLog)) {
                    QuizLog::create([
                        'user_id'   => intval($tester),
                        'topics_id' => $id,
                        'is_finish' => 0,
                        'title'     => $request->input('title'),
                        'username'  => $user->name,
                    ]);
                }
            }
        }
        // 对比提交上来的参试者与考试记录的数量做对比
        // 若是发现考试记录的参数者在 提交的参试者中不存在，则说明取消该参试者的考试资格
        $user = Auth::user();
        $thisQuiztesters = QuizLog::where('topics_id', $id)->where('user_id', $user->id)->get();
        $data = [];
        foreach ($thisQuiztesters as $index => $thisQuiztester) {
            $data[$index] = [
                'logMode' => $thisQuiztester,
                'is_join' => false,
            ];
            // if ($testers) {
                foreach ($testers as $tester) {
                    if ($thisQuiztester->user_id == intval($tester)) {
                        $data[$index]['is_join'] = true;
                    }
                }
            // }
        }
        foreach ($data as $index => $key) {
            if (!$key['is_join']) {
                $key['logMode']->delete();
            }
        }
        return redirect()->route('topics.index');
    }


    /**
     * Display Topic.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $topic = Topic::findOrFail($id);
        $users = QuizLog::where('topics_id', $id)->get();
        return view('topics.show', compact('topic', 'users'));
    }


    /**
     * Remove Topic from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();

        return redirect()->route('topics.index');
    }

    /**
     * Delete all selected Topic at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if ($request->input('ids')) {
            $entries = Topic::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
            // 删除考试科目需要同时删除考试记录，否则会在获取考试科目时会出错
            $quizLogs = QuizLog::where('topics_id', $request->input('ids'))->get();
            foreach ($quizLogs as $quizLog) {
                $quizLog->delete();
            }
        }
    }

    /*
     * status = 0 表示考试未开始
     * statue = 1 表示考试已经开始
     * statue = -1 表示已经超时考试时间
     */
    public function showtest()
    {
        // $topics = Topic::all();
        $user = Auth::user();
        // $topics = QuizLog::where('user_id', $user->id)->where('is_finish', 0)->get();
        $quizDatas = QuizLog::where('user_id', $user->id)->where('is_finish', 0)->get();
        // var_dump($user->id);
        $topics = [];
        $noQuiz = 0;
        foreach ($quizDatas as $key => $quizData) {
            
            $topic = Topic::where('id', $quizData->topics_id)->first();
            // var_dump($topic);
            // var_dump($quizData->topics_id);
            // die();
            $topics[$key]['topics_id'] = $quizData->topics_id;
            $topics[$key]['title'] = $quizData->title;
            $topics[$key]['quiz_time'] = $topic->quiz_time;
            $topics[$key]['start_time'] = $topic->start_time;
            $topics[$key]['status'] = $this->getQuizStatus($topic->start_time, $topic->quiz_time);
            if ($topics[$key]['status'] >= 0) {
                $noQuiz = 1;
            }

        }
        // var_dump($topics);
        // var_dump($noQuiz);
        // die();
        return view('tests.show', compact('topics', 'noQuiz'));
    }

    public function getQuizStatus($startTime, $quizTime)
    {
        $currrent = Carbon::now('Asia/Shanghai');
        $start = new Carbon($startTime, 'Asia/Shanghai');
        $end = new Carbon($startTime, 'Asia/Shanghai');
        $end = $end->addMinutes(intval($quizTime));

        $currrent_time = $currrent->timestamp;
        $start_time = $start->timestamp;
        $end_time = $end->timestamp;
        // 0 时间未到
        if ($currrent_time-$start_time < 0) { // false 
            return 0;
        }

        // if ($currrent->gte($start) && $currrent->lt($end)) { // 大于 gt 小于 lt
        if ($currrent_time-$start_time > 0 && $currrent_time-$end_time < 0) {
            var_dump($currrent_time-$start_time > 0 && $currrent_time-$end_time < 0);
            return 1;
        }

        if ($currrent_time-$end_time > 0) return -1;
    }

    public function resetQuiz(Request $request)
    {
        $topicId = $request->input('id');
        $quizLogs = QuizLog::where('topics_id', $topicId)->get();
        foreach ($quizLogs as $quizLog) {
            $quizLog->is_finish = 0;
            $quizLog->save();
        }
        return response()->json(['code' => 1, 'des' => 'success']);
    }
}
