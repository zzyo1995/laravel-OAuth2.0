@extends('layouts.master')

@section('title')
@parent
:: 忘记密码
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
    <h2>忘记密码</h2>
</div>

{{ Form::open([
    'url' => 'password/remind',
    'class' => 'form-horizontal',
    'role' => 'form'
]) }}
    <!-- 邮件地址 -->
    <div class="form-group {{{ $errors->has('email') ? 'has-error' : '' }}}">
        {{ Form::label('email', '电子邮件', ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
                {{ Form::text('email', '', ['class' => 'form-control']) }}
            </div>
        </div>
        <p class="col-sm-3 form-control-static text-danger">
            {{ $errors->first('email') }}
        </p>
    </div>

    <!-- 提交按钮 -->
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            {{ Form::submit('发送', ['class' => 'btn btn-warning']) }}
        </div>
    </div>
{{ Form::close() }}
@stop
