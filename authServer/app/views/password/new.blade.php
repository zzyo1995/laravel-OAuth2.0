@extends('layouts.master')

@section('title')
@parent
:: 修改密码
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
    <h2>修改密码{{$user->email}}</h2>
</div>

{{ Form::open(array('url' => 'users/'.$user->id, 'method' => 'put', 'class' => 'form-horizontal', 'role' => 'form')) }}
    <!-- 旧密码 -->
    <div class="form-group {{{ $errors->has('oldpassword') ? 'has-error' : '' }}}">
        {{ Form::label('oldpassword', '旧密码', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                {{ Form::password('oldpassword', array('class' => 'form-control')) }}
            </div>
        </div>
        <p class="col-sm-3 form-control-static text-danger">
            {{ $errors->first('oldpassword') }}
        </p>
    </div>

    <!-- 新密码 -->
    <div class="form-group {{{ $errors->has('password') ? 'has-error' : '' }}}">
        {{ Form::label('password', '新密码', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                {{ Form::password('password', array('class' => 'form-control')) }}
            </div>
        </div>
        <p class="col-sm-3 form-control-static text-danger">
            {{ $errors->first('password') }}
        </p>
    </div>

    <!-- 密码确认 -->
    <div class="form-group {{{ $errors->has('password_confirmation') ? 'has-error' : '' }}}">
        {{ Form::label('password_confirmation', '密码确认', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-check"></span></span>
                {{ Form::password('password_confirmation', array('class' => 'form-control')) }}
            </div>
        </div>
        <p class="col-sm-3 form-control-static text-danger">
            {{ $errors->first('password_confirmation') }}
        </p>
    </div>

    <!-- 修改按钮 -->
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            {{ Form::submit('修改', array('class' => 'btn btn-info')) }}
        </div>
    </div>
    {{ Form::hidden('mode', 'new-password') }}
{{ Form::close() }}
@stop
