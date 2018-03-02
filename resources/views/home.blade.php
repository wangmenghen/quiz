@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome! 下面是一些数据在考试系统中.</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <h1>{{ $questions }}</h1>
                            在我们的数据库
                        </div>
                        <div class="col-md-3 text-center">
                            <h1>{{ $users }}</h1>
                            已注册用户数
                        </div>
                        <div class="col-md-3 text-center">
                            <h1>{{ $quizzes }}</h1>
                            已完成的考试
                        </div>
                        <div class="col-md-3 text-center">
                            <h1>{{ number_format($average, 2) }} / 30</h1>
                            平均分数
                        </div>
                    </div>
                </div>
            </div>
            <a href="/showtest" class="btn btn-success">开始一个新的考试!</a>
        </div>
    </div>
@endsection
