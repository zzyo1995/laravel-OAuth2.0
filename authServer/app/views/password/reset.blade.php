@extends('layouts.master')

@section('title')
@parent
:: 修改密码
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
    <h2>重置密码</h2>
</div>

{{ Form::open(['url' => 'password/reset',
    'class' => 'form-horizontal',
    'role' => 'form'
]) }}
    <!-- 邮件地址 -->
    <div class="form-group {{{ $errors->has('email') ? 'has-error' : '' }}}">
        {{ Form::label('email', '电子邮件', ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                {{ Form::text('email', Input::old('email'), [
                    'placeholder' => 'youremail@someprovider.com',
                    'class' => 'form-control'
                ]) }}
            </div>
        </div>
        <p class="col-sm-3 form-control-static text-danger">
            {{ $errors->first('email') }}
        </p>
    </div>

    <!-- 新密码 -->
    <div class="form-group {{{ $errors->has('password') ? 'has-error' : '' }}}">
        {{ Form::label('password', '新密码', ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                {{ Form::password('password', ['class' => 'form-control']) }}
            </div>
        </div>
        <p class="col-sm-3 form-control-static text-danger">
            {{ $errors->first('password') }}
        </p>
    </div>

    <!-- 密码确认 -->
    <div class="form-group {{{ $errors->has('password_confirmation') ? 'has-error' : '' }}}">
        {{ Form::label('password_confirmation', '新密码确认', ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-check"></span></span>
                {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
            </div>
        </div>
        <p class="col-sm-3 form-control-static text-danger">
            {{ $errors->first('password_confirmation') }}
        </p>
    </div>

    <!-- 修改按钮 -->
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            {{ Form::submit('修改', ['class' => 'btn btn-info']) }}
        </div>
    </div>
    {{ Form::hidden('token', $token) }}
{{ Form::close() }}
@stop
