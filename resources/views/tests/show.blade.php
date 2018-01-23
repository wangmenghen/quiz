@extends('layouts.app')

@section('content')
    <h3 class="page-title">选则你要参加的考试</h3>

    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-bordered table-striped dt-select">
                <thead>
                    <tr>
                        
                        <th>考试科目</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($topics) > 0)
                        @foreach ($topics as $topic)
                            <tr data-entry-id="{{ $topic->id }}">
                                
                                <td>{{ $topic->title }}</td>
                                <td><a href="/testIndex/{{ $topic->id }}" class="btn btn-xs btn-primary">开始</a></td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3">@lang('quickadmin.no_entries_in_table')</td>
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