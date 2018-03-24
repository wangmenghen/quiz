@extends('layouts.app')

@section('content')
    <h3 class="page-title">个人信息</h3>
    <div class="panel panel-default">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    <label style="width:100px; marge-left:15px" for="">用户名 :</label>
                    <label for="">{{$user->name}}</label> 
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    <label style="width:100px; marge-left:15px" for="">邮箱 :</label>
                    <label for="">{{$user->email}}</label>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    <label style="width:100px; marge-left:15px" for="">密码 :</label>
                    <label for="">***********</label>
                </div>
            </div>  
        </div>
        <a href="/user/edit" style="width:100px;margin-left: 15px;margin-bottom: 15px" class="btn btn-danger">修改</a>
    </div>
@stop

