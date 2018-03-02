@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.topics.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['topics.store']]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.create')
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
                    <select id="quizTime" class="js-example-basic-single" name="quizTime" style="width:100px">
                        <option value="60">60分钟</option>
                        <option value="90">90分钟</option>
                        <option value="120">120分钟</option>
                    </select>
                </div>
                <div class="col-xs-12 form-group">
                    <label class="" for="">考试开始时间</label>
                    <div id="datepicker"></div>
                    <input type="text" id="d233" class="Wdate" name="startTime"
                     onclick="WdatePicker(
                        {startDate: '%y-%M-01 00:00:00',
                            dateFmt: 'yyyy-MM-dd HH:mm:ss',
                            alwaysUseStartDate:true,
                            minDate:'%y-%M-%d'
                        })"/>
                </div>
                <div class="col-xs-12 form-group"><i class="fa fa-users"></i><label class="" for="">选定参试人员</label></div>
                <div class="col-xs-12 form-group">  
                    @foreach ($users as $user)
                        <div class="col-md-2">
                            <span class="input-group-addon">
                                <input type="checkbox" value="{{$user->id}}" name="tester[]">
                                <span>{{$user->name}}</span>
                            </span>
                            
                        </div>
                    @endforeach 
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

