@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.results.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.view-result')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        @if(Auth::user()->isAdmin())
                        <tr>
                            <th>@lang('quickadmin.results.fields.user')</th>
                            <td>{{ $test->user->name or '' }} ({{ $test->user->email or '' }})</td>
                        </tr>
                        @endif
                        <tr>
                            <th>@lang('quickadmin.results.fields.date')</th>
                            <td>{{ $test->created_at or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.results.fields.result')</th>
                            <td>{{ $test->result }}/10</td>
                        </tr>
                    </table>
                <?php $i = 1 ?>
                @foreach($results as $result)
                <br>
                    <table class="table table-bordered table-striped">
                        <tr class="test-option{{ $result->correct ? '-true' : '-false' }}">
                            <th style="width: 10%">题 #{{ $i }}</th>
                            <th>{{ $result->question->question_text or '' }}</th>
                        </tr>
                        @if ($result->question->code_snippet != '')
                            <tr>
                                <td>Code snippet</td>
                                <td><div class="code_snippet">{!! $result->question->code_snippet !!}</div></td>
                            </tr>
                        @endif
                        <tr>
                            <td>选项</td>
                            <td>
                                <ul>
                                @foreach($result->question->options as $option)
                                    @if ($result->question->type == 1)
                                        <li style="@if ($option->correct == 1) font-weight: bold; @endif
                                            @if ($result->option_id == $option->id) text-decoration: underline @endif">{{ $option->option }}
                                            @if ($option->correct == 1) <em>(正确答案)</em> @endif
                                            @if ($result->option_id == $option->id) <em>(你提交的答案)</em> @endif
                                        </li>
                                    @endif
                                    @if ($result->question->type == 2)
                                        <li style="@if ($option->correct == 1) font-weight: bold; @endif
                                            @if ($option->submit) text-decoration: underline @endif">{{ $option->option }}
                                            @if ($option->correct == 1) <em>(正确答案)</em> @endif
                                            @if ($option->submit) <em>(你提交的答案)</em> @endif
                                        </li>
                                    @endif
                                @endforeach
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td>答案解析</td>
                            <td>
                            {!! $result->question->answer_explanation  !!}
                                @if ($result->question->more_info_link != '')
                                    <br>
                                    <br>
                                    查看更多:
                                    <a href="{{ $result->question->more_info_link }}" target="_blank">{{ $result->question->more_info_link }}</a>
                                @endif
                            </td>
                        </tr>
                    </table>
                <?php $i++ ?>
                @endforeach
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="/showtest" class="btn btn-default">开始下一个考试</a>
            <a href="{{ route('results.index') }}" class="btn btn-default">查看我全的考试结果</a>
        </div>
    </div>
@stop
