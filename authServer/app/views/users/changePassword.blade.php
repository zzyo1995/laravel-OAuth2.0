@extends('layouts.admin')

@section('title')
修改密码
@stop

@section('content')
		<h2 class="offset4">修改密码</h2>
		<hr />
		{{ Form::open(array('url'=>'users/'.Auth::user()->id,'class'=>'form-horizontal offset4','method'=>'put','role'=>'form')) }}
		<!-- 原密码 -->
			<div class="form-group {{ isset($errors->old_password)?has-error:'' }}">
				<label class="col-md-2 control-label" for="old_password">原密码</label>
				<div class="col-md-4">
					{{ Form::password('old_password',array('class'=>'form-control')) }}
				</div>
				<span class="form-feed-back">{{ $errors->first('old_password') }}</span>
			</div>
			
		<!-- 新密码 -->
			<div class="form-group {{ isset($errors->password)?has-error:'' }}">
				<label class="col-md-2 control-label" for="password">新密码</label>
				<div class="col-md-4">
					{{ Form::password('password',array('class'=>'form-control')) }}
				</div>
				<span class="form-feed-back">{{ $errors->first('password') }}</span>
			</div>
			
			<div class="form-group {{ isset($errors->confirmation_password)?has-error:'' }}">
				<label class="col-md-2 control-label" for="password_confirmation">新密码</label>
				<div class="col-md-4">
					{{ Form::password('password_confirmation',array('class'=>'form-control')) }}
				</div>
				<span class="form-feed-back">{{ $errors->first('confirmation_password') }}</span>
			</div>
			{{ Form::hidden('signal','password') }}
			<div class="col-md-3 offset4">
				{{ Form::submit('修改密码',array('class'=>'btn btn-primary')) }}
				{{ Form::button('取消',array('class'=>'btn btn-cancel')) }}
			</div>
		{{ Form::close() }}
@stop
