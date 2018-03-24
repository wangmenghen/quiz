@extends('layouts.app')

@section('content')
    <h3 class="page-title">选择你要参加的考试</h3>

    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-bordered table-striped dt-select">
                <thead>
                    <tr>
                        
                        <th>考试科目</th>
                        <th>考试时间</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if ($noQuiz == 1 && count($topics) > 0)
                        @foreach ($topics as $topic)
                            @if ($topic['status'] != -1)
                            <tr data-entry-id="{{ $topic['topics_id'] }}">
                                
                                <td>{{ $topic['title'] }}</td>
                                <td>{{ $topic['start_time'] }}</td>
                                <td>
                                    <!-- <a href="/testIndex/{{ $topic['topics_id'] }}" class="btn btn-xs btn-primary">开始
                                    </a> -->
                                    @if ($topic['status'] == 0)
                                    <a href="/testIndex/{{ $topic['topics_id'] }}" class="btn btn-xs btn-primary" disabled="disabled">
                                    考试未开始
                                    </a>
                                    @endif

                                    @if ($topic['status'] == 1)
                                    <a href="/testIndex/{{ $topic['topics_id'] }}" class="btn btn-xs btn-primary">
                                    开始
                                    </a>
                                    @endif

                                    <!-- @if ($topic['status'] == -1)
                                    <a href="/testIndex/{{ $topic['topics_id'] }}" class="btn btn-xs btn-primary hide">
                                    开始
                                    </a>
                                    @endif -->
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    @else
                        <tr>
                            <!-- <td colspan="3">@lang('quickadmin.no_entries_in_table')</td> -->
                            <td colspan="3">近期没有考试</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        window.route_mass_crud_entries_destroy = '{{ route('topics.mass_destroy') }}';
    </script>
@endsection