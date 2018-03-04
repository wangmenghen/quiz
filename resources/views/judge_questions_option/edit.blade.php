@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.questions.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['questions_options.judgeUpdate']]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.edit')
        </div>
        <input type="hidden" name="id" value="{{$questions->id}}">
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('topic_id', '试卷*', ['class' => 'control-label']) !!}
                    {!! Form::select('topic_id', $topics, old('topic_id'), ['class' => 'form-control judge-select']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('topic_id'))
                        <p class="help-block">
                            {{ $errors->first('topic_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('question_text', '题目描述*', ['class' => 'control-label']) !!}
                    {!! Form::textarea('question_text', old('question_text'), ['class' => 'form-control ', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('question_text'))
                        <p class="help-block">
                            {{ $errors->first('question_text') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    <label class="" for="">题目类型</label>
                    <select id ="type" class="js-example-basic-single" name="type" style="width:100px">
                        <option value="3">判断题</option>
                    </select>
                </div>
            </div>
            <div id="judge">
                <div class="row">
                    <div class="col-xs-12 form-group">
                        {!! Form::label('judge_correct', '是否正确', ['class' => 'control-label']) !!}
                        {!! Form::hidden('judge_correct', 0) !!}
                        {!! Form::checkbox('judge_correct', 1, old('judge_correct', 0), ['class' => 'form-control judge_checkbox']) !!}
                        <!-- <input type="checkbox" name="judge_correct"> -->
                        <p class="help-block"></p>
                        @if($errors->has('judge_correct'))
                            <p class="help-block">
                                {{ $errors->first('judge_correct') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('answer_explanation', '答案解析*', ['class' => 'control-label']) !!}
                    {!! Form::textarea('answer_explanation', old('answer_explanation'), ['class' => 'form-control judge-explanation', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('answer_explanation'))
                        <p class="help-block">
                            {{ $errors->first('answer_explanation') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('more_info_link', '相关链接', ['class' => 'control-label']) !!}
                    {!! Form::text('more_info_link', old('more_info_link'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('more_info_link'))
                        <p class="help-block">
                            {{ $errors->first('more_info_link') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
    </form>
    <script>
        $(document).ready(function() {
            $("#question_text").text('{{$questions->question_text}}');
            $(".judge-select").val('{{$questions->topic_id}}');
            $(".judge-explanation").text('{{$questions->answer_explanation}}');
            $("#more_info_link").val('{{$questions->more_info_link}}');
            if ({{$questions->judge_correct}}) {
                $(".judge_checkbox").attr("checked", true);
            }
        })
    </script>
@stop

