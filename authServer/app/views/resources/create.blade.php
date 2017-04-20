@extends('layouts.master')

@section('title')
@parent
:: 注册资源服务器
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
    <h2>注册资源服务器</h2>
</div>

{{ Form::open(array('url' => 'resources', 'class' => 'form-horizontal', 'role' => 'form')) }}
    <!-- 资源服务器名称 -->
    <div class="form-group {{{ isset($errors->username) ? 'has-error' : '' }}}">
        {{ Form::label('name', '资源服务器名称', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-3">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-quote-left fa-fw"></i></span></span>
                {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
            </div>
        </div>
        <p class="col-md-3 form-control-static text-danger">
            {{ $errors->first('name') }}
        </p>
    </div>

<!-- 资源服务器密码-->
<div class="form-group {{{ isset($errors->password) ? 'has-error' : '' }}}">
    {{ Form::label('scope', '资源服务器密码', ['class' => 'col-md-2 control-label']) }}
    <div class="col-md-3">
        <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
    	{{ Form::password('password',array('class'=>'form-control')) }}
        </div>
    </div>
    <p class="col-md-3 form-control-static text-danger">
        {{ $errors->first('password') }}
    </p>
</div>
<!-- 资源服务器密码-->
<div class="form-group {{{ isset($errors->password_confirmation) ? 'has-error' : '' }}}">
    {{ Form::label('scope', '资源服务器密码确认', ['class' => 'col-md-2 control-label']) }}
    <div class="col-md-3">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-check-circle fa-fw"></i></span>
    	    {{ Form::password('password_confirmation',array('class'=>'form-control')) }}
        </div>
    </div>
    <p class="col-md-3 form-control-static text-danger">
        {{ $errors->first('password_confirmation') }}
    </p>
</div>
<!-- 注册按钮 -->
<div class="form-group">
    <div class="offset3 col-md-2">
        {{ Form::submit('注册', array('class' => 'btn btn-success')) }}
        {{ Form::reset('取消',array('class'=>'btn btn-cancel')) }}
    </div>
</div>

<!-- 测试用 -->
<!--{{ Form::hidden('access_token', '11bBY7avOXmDMY3zygcYxUSrJdiAImhnPtgU3nVn') }}-->

{{ Form::close() }}
@stop
    <!-- 注册按钮 -->
    <div class="form-group">
        <div class="col-md-2 offset4">
            {{ Form::submit('注册', array('class' => 'btn btn-success')) }}
        </div>
    </div>

    <!-- 测试用 -->
    <!--{{ Form::hidden('access_token', '11bBY7avOXmDMY3zygcYxUSrJdiAImhnPtgU3nVn') }}-->

{{ Form::close() }}
@stop
