@extends('layouts.master')

@section('title')
@parent
:: 注册新用户
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
    <h2>注册新用户</h2>
</div>

{{ Form::open(array('url' => 'users', 'class' => 'form-horizontal', 'role' => 'form')) }}
    <!-- 姓名
    <div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
        {{ Form::label('name', '姓名', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
            </div>
        </div>
        <p class="col-sm-3 form-control-static text-danger">
            {{ $errors->first('name') }}
        </p>
    </div> -->

    <!-- 昵称 -->
    <div class="form-group {{{ $errors->has('username') ? 'has-error' : '' }}}">
        {{ Form::label('username', '用户名', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-flag fa-fw"></i></span></span>
                {{ Form::text('username', Input::old('username'), array('class' => 'form-control')) }}
            </div>
        </div>
        <p class="col-sm-3 form-control-static text-danger">
            {{ $errors->first('username') }}
        </p>
    </div>

    <!-- 用户类别 -->
    <div class="form-group {{{ $errors->has('user_category') ? 'has-error' : '' }}}">
        {{ Form::label('user_category', '用户类别', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-flag fa-fw"></i></span></span>
                    <select name="user_category">
                    @foreach ($roles as $role)
                            <option value={{ $role->name }}>{{ $role->description }}</option>
                    @endforeach
                    </select>
            </div>
        </div>
        <p class="col-sm-3 form-control-static text-danger">
            {{ $errors->first('usercategory') }}
        </p>
    </div>

    <!-- 项目组 -->
    <div class="form-group {{{ $errors->has('project_group') ? 'has-error' : '' }}}">
        {{ Form::label('project_group', '项目组', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-flag fa-fw"></i></span></span>
                    <select name="project_group">
                    @foreach ($groups as $group)
                            <option value={{ $group->id }}>{{ $group->name }}</option>
                    @endforeach
                    </select>
            </div>
        </div>
        <p class="col-sm-3 form-control-static text-danger">
            {{ $errors->first('project_group') }}
        </p>
    </div>

    <!-- 邮箱 -->
    <div class="form-group {{{ $errors->has('email') ? 'has-error' : '' }}}">
        {{ Form::label('email', '电子邮件', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
                {{ Form::text('email', Input::old('email'), array('placeholder' => 'youremail@someprovider.com', 'class' => 'form-control')) }}
            </div>
        </div>
        <p class="col-sm-3 form-control-static text-danger">
            {{ $errors->first('email') }}
        </p>
    </div>

    <!-- 密码 -->
    <div class="form-group {{{ $errors->has('password') ? 'has-error' : '' }}}">
        {{ Form::label('password', '密码', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
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
                <span class="input-group-addon"><i class="fa fa-check-circle fa-fw"></i></span>
                {{ Form::password('password_confirmation', array('class' => 'form-control')) }}
            </div>
        </div>
        <p class="col-sm-3 form-control-static text-danger">
            {{ $errors->first('password_confirmation') }}
        </p>
    </div>

    <!-- 注册按钮 -->
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            {{ Form::submit('注册', array('class' => 'btn btn-success')) }}
        </div>
    </div>

    <!-- 测试用 -->
    <!--{{ Form::hidden('access_token', '11bBY7avOXmDMY3zygcYxUSrJdiAImhnPtgU3nVn') }}-->
        
{{ Form::close() }}
@stop
