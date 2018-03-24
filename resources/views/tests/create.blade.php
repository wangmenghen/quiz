@extends('layouts.app')

@section('content')
    <h3 class="page-title">{{$title}} 考试</h3>
    <div id="timer" class="countdown"> 
        <p class="mtp"><span class="countdown_text">答题倒计时</span></p>
        <p class="line_height34"><span id="countdown_time"></span><span class="countdown_text">分钟</span></p>
        <p class="line_height34 time-over__p"><span id="time_over" class="countdown_text"></span></p>
    </div>

    <form action="{{ route('tests.store') }}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="panel panel-default">
        <div class="panel-heading">
        </div>
    @if(count($questions) > 0)
        <div class="panel-body">
        <?php $i = 1; ?>
        @foreach($questions as $question)
            @if ($i > 1) <hr /> @endif
            <div class="row">
                <div class="col-xs-12 form-group">
                    <div class="form-group">
                        <strong>题 {{ $i }}#.{!! nl2br($question->question_text) !!} 
                        @if ($question->type == 1)
                            (单选题)
                        @endif
                        @if ($question->type == 2)
                            (多选题)
                        @endif
                        @if ($question->type == 3)
                            (判断题)
                        @endif
                        </strong>
                        <br/>
                        @if ($question->code_snippet != '')
                            <div class="code_snippet">{!! $question->code_snippet !!}</div>
                        @endif

                        
                            <!-- 作答的题目id 和 回答的选项id -->
                    <!-- 单选 -->
                    @if ($question->type == 1) 
                        <input
                            type="hidden"
                            name="questions[{{ $i }}]"
                            value="{{ $question->id }}">
                    @foreach($question->options as $option)
                        <br>
                        <label class="radio-inline">
                            <input
                                type="radio"
                                name="answers[{{ $question->id }}]"
                                value="{{ $option->id }}">
                            {{ $option->option }}
                        </label>
                    @endforeach
                    @endif

                    <!-- 多选 -->
                    @if ($question->type == 2) 
                        <input type="hidden" id='hidMult' 
                               name="questionsMult[{{ $i }}]"
                               value="{{ $question->id }}">
                    @foreach($question->options as $option)
                        <br>
                        <label class="radio-inline">
                            <input
                                type="checkbox"
                                name="answersMult-{{ $question->id }}[]"
                                value="{{ $option->id }}">
                            {{ $option->option }}
                        </label>
                    @endforeach
                    @endif

                    <!-- 多选 -->
                    @if ($question->type == 3) 
                        <input type="hidden" id='hidJudge' 
                               name="questionsjudge[{{ $i }}]"
                               value="{{ $question->id }}">
                        <input type="radio" name="answersJudge-{{ $question->id }}" value='1'>正确
                        <input type="radio" name="answersJudge-{{ $question->id }}" value='0'>错误
                    @endif
                    </div>
                </div>
            </div>
        <?php $i++; ?>
        @endforeach
        </div>
    @endif
    </div>

    {!! Form::submit(trans('quickadmin.submit_quiz'), ['class' => 'btn btn-danger quiz_submit']) !!}
    <input type="hidden" name="topicId" value="{{$topicId}}">
    </form>
@stop

@section('javascript')
    @parent
    <script src="{{ url('quickadmin/js') }}/timepicker.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script> -->
    <script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>


    <script>
        $(function() {
            //设置时间倒计时
            setCountDown_time();
        })
        /*时间倒计时*/
        var quizTime = {{$quizTime}};
        var startTime = '{{$startTime}}';
        var now = moment();
        var end = moment(startTime).add(quizTime, 'm');
        
        var ms = end.diff(now);
        var minutes = parseInt((ms % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = parseInt((ms % (1000 * 60)) / 1000);
        var sec = seconds;
        var min = minutes;
        
        // if (parseInt(localStorage.getItem('interrupt')) === 0) {
        //     console.log('setting')
        //     console.log('sec', localStorage);
        //     sec = localStorage.getItem('sec');
        //     min = localStorage.getItem('min');
        //     console.log('sec::', sec);
        //     console.log('min::', min);
        // }
        var format = function(str) {
            if(parseInt(str) < 10) {
                return "0" + str;
            }
            return str;
        };
        var idt;
        function setCountDown_time(){
            idt = window.setInterval("ls();", 1000);
        }
        function ls() {
            sec--;
            if(sec == 0) {
                min--;
                sec = 59;
            }
            document.getElementById("countdown_time").innerHTML = format(min) + ":" + format(sec);
            if (parseInt(min) == 0 && parseInt(sec) == 1) {
                window.clearInterval(idt);
                // document.getElementById("countdown_time").innerHTML = '考试结束！';
                $('#countdown_time').hide();
                $('.mtp').hide();
                $('.countdown_text').hide();
                // alert('考试时间已到，试卷已提交，感谢您的使用！');
                $('#time_over').html('考试结束！').show();
                localStorage.setItem('interrupt', 0);
                $('.quiz_submit').click();
            }
        }
        // $(window).bind('beforeunload',function(){
        //     localStorage.setItem('min', min);
        //     localStorage.setItem('sec', sec);
        //     localStorage.setItem('interrupt', 1);
        //     return '您输入的内容尚未保存，确定离开此页面吗？';
        // });
        // $('.quiz_submit').click(function() {
        //     console.log('clear');
        //     localStorage.setItem('min', 0);
        //     localStorage.setItem('sec', 0);
        //     localStorage.setItem('interrupt', 0);
        //     $('form').submit();
        // })
        // window.onbeforeunload = function() {
        //     localStorage.setItem('min', min);
        //     localStorage.setItem('sec', sec);
        //     localStorage.setItem('interrupt', 1)
        //     return "请点击取消留在此页";
        // }
    </script>
@stop
