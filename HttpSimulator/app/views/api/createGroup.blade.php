@extends('layouts.master')
@section('title')
    @parent :: 接口
@stop

@section('content')
    {{--    <div>
        {{ Form::open(array('url' => 'register')) }}
        {{ Form::label('username', 'UserName') }}
        {{ Form::text('username') }}<br/>
        {{ Form::label('email', 'Email') }}
        {{ Form::text('email') }}<br/>
        {{ Form::label('password', 'Password') }}
        {{ Form::password('password') }}<br/>
        {{ Form::submit('Sign up') }}
        {{ Form::close() }}
        </div>--}}
    <div class="row" style="padding-top: 100px">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            {{ Form::open(array('url' => '/api-manage/addGroup', 'method'=>'post', 'class' => 'form-horizontal')) }}
            <div class="form-group">
                {{ Form::label('name', 'GroupName') }}
                {{ Form::text('name','',array('class'=>'form-control', 'id'=>'name', 'placeholder'=>'GroupName') ) }}
            </div>
            <div class="form-group">
                {{ Form::label('description', 'Description') }}
                {{ Form::text('description','',array('class'=>'form-control', 'id'=>'description', 'placeholder'=>'Description') ) }}
            </div>
            {{ Form::submit('创建',array('class'=>'btn btn-default')) }}
            {{ Form::close() }}
        </div>
        <div class="col-md-3"></div>
    </div>

@stop