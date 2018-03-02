@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.topics.title')</h3>
    
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.view')
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>考试科目</th>
                            <td>{{ $topic->title }}</td>
                        </tr>
                        <tr>
                            <th>考试时间</th>
                            <td>{{ $topic->quiz_time }}分钟</td>
                        </tr>
                        <tr>
                            <th>开始时间</th>
                            <td>{{ $topic->start_time }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-xs-12 form-group"><i class="fa fa-users"></i><label class="" for="">参试人员</label></div>
                <div class="col-xs-12 form-group">  
                    @foreach ($users as $user)
                        <div class="col-md-2">
                            <span class="input-group-addon">
                                <span>{{$user->username}}</span>
                            </span>
                        </div>
                    @endforeach 
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('topics.index') }}" class="btn btn-default">@lang('quickadmin.back_to_list')</a>
        </div>
    </div>
@stop