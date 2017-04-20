@extends('layouts.admin')

@section('title')
用户管理 < @parent
@stop

{{-- Content --}}
@section('caption')
用户信息修改
@stop
@section('content')

{{ Form::open(array('url' => 'manage/changeUserInfo', 'class' => 'form-horizontal',  'method' => 'post')) }}
    <div class="form-group {{{ $errors->has('username') ? 'has-error' : '' }}}">
        {{ Form::label('username', '用户名', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-flag fa-fw"></i></span></span>
                {{ Form::text('username', $username, array('placeholder' => $username, 'class' => 'form-control')) }}
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
                    		@if ($role->name == $user_category)
                            	<option selected= "selected" value={{ $role->name }}>{{ $role->description }}</option>
                            @else
                            	<option value={{ $role->name }}>{{ $role->description }}</option>
                            @endif
                    @endforeach
                    </select>
            </div>
        </div>
        <p class="col-sm-3 form-control-static text-danger">
            {{ $errors->first('usercategory') }}
        </p>
    </div>

    <!-- 邮箱 -->
    <div class="form-group {{{ $errors->has('email') ? 'has-error' : '' }}}">
        {{ Form::label('email', '电子邮件', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
                {{ Form::text('email', $email, array('placeholder' => $email, 'class' => 'form-control')) }}
            </div>
        </div>
        <p class="col-sm-3 form-control-static text-danger">
            {{ $errors->first('email') }}
        </p>
    </div>
	{{ Form::hidden('id', $id) }}
    {{ Form::hidden('old_username', $username) }}
    {{ Form::hidden('old_email', $email) }}
    {{ Form::hidden('old_user_category', $user_category) }}
    <!-- 提交 -->
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            {{ Form::submit('提交', array('class' => 'btn btn-success')) }}
        </div>
    </div>
  
{{ Form::close() }}
@stop
