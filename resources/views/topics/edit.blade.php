@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.topics.title')</h3>
    
    {!! Form::model($topic, ['method' => 'PUT', 'route' => ['topics.update', $topic->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('title', '试卷名*', ['class' => 'control-label']) !!}
                    {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('title'))
                        <p class="help-block">
                            {{ $errors->first('title') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-12 form-group">
                    <label class="" for="">考试时间</label>
                    <select id="quizTimeEdit" class="js-example-basic-single" name="quizTime" style="width:100px" value="{{$topic->quiz_time}}">
                        <option value="60">60分钟</option>
                        <option value="90">90分钟</option>
                        <option value="120">120分钟</option>
                    </select>
                </div>
                <div class="col-xs-12 form-group">
                    <label class="" for="">考试开始时间</label>
                    <div id="datepicker"></div>
                    <input type="text" id="d233" class="Wdate" name="startTime" value="{{$topic->start_time}}"
                     onclick="WdatePicker(
                        {startDate: '%y-%M-01 00:00:00',
                            dateFmt: 'yyyy-MM-dd HH:mm:ss',
                            alwaysUseStartDate:true,
                            minDate:'%y-%M-%d'
                        })"/>
                </div>
                <div class="col-xs-12 form-group"><i class="fa fa-users">
                    </i><label class="" for="">选定参试人员</label>
                    <input type="checkbox" id="allCheck" class="allCheck" name="selectall">全选
                </div>
                <div class="col-xs-12 form-group">  
                    @foreach ($users as $user)
                        <div class="col-md-2">
                            <span class="input-group-addon">
                            @if ($user->join  == 1)
                                <input type="checkbox" value="{{$user->id}}" name="tester[]" checked = 'checked'>
                            @endif
                            @if ($user->join  == 0) 
                                <input type="checkbox" value="{{$user->id}}" name="tester[]">
                            @endif
                                <span>{{$user->name}}</span>
                            </span>
                            
                        </div>
                    @endforeach 
                </div>
            </div>
            
        </div>
    </div>
    
    {!! Form::submit(trans('quickadmin.update'), ['class' => 'btn btn-danger']) !!}
    @if ($role  == 1)
    <a id="restart" class="btn btn-danger">重新开启考试</a>
    @endif
    {!! Form::close() !!}
    <script>
        $(document).ready(function() {
            // $("#quizTimeEdit").select2('val','{{$topic->quiz_time}}')
            $("#quizTimeEdit").val({{$topic->quiz_time}}).trigger("change")
            $("#restart").click(function() {
                $.post("/reset",
                    {id: {{$topicId}}},
                    function(result) {
                    alert('ok!');
                });
            });
            $('input[name="selectall"]').click(function(){
                if($(this).is(':checked')){  
                    $('input[name="tester[]"]').each(function(){  
                        $(this).prop("checked",true);  
                    });
                }else{  
                    $('input[name="tester[]"]').each(function(){  
                        $(this).removeAttr("checked",false);  
                    });
                }  
            })
        })
    </script>
@stop

