@extends('layouts.admin')

@section('title')
用户信息修改
@stop

@section('content')
		<h2 class="offset4">用户信息</h2>
		<hr />
		{{ Form::open(array('url'=>'users/'.$userInfo->id,'method'=>'put','class'=>'form-horizontal offset4','role'=>'form')) }}
		
		<!-- 用户id -->
			<div class="form-group">
				<label class="control-label col-md-2" for="userId">用户id：</label>
				<div class="col-md-4">
					{{ Form::text('userId',$userInfo->id,array('class'=>'form-control','readonly'=>'true')) }}
				</div>
			</div>

		<!-- 认证服务器对应id -->
			<div class="form-group">
				<label class="control-label col-md-2" for="authId">认证id：</label>
				<div class="col-md-4">
					{{ Form::text('authId',$userInfo->userId,array('class'=>'form-control','readonly'=>'true')) }}
				</div>
			</div>
		<!-- 用户名 -->
			<div class="form-group  {{ isset($errors->username)?has-error:'' }}">
				<label class="control-label col-md-2" for="username">用户名：</label>
				<div class="col-md-4">
					{{ Form::text('username',$userInfo->username,array('class'=>'form-control')) }}
				</div>
				<span class="form-feed-back">{{ $errors->first('username') }}</span>
			</div>
			
		<!-- email -->
			<div class="form-group  {{ isset($errors->email)?has-error:'' }}">
				<label class="control-label col-md-2" for="email">邮箱：</label>
				<div class="col-md-4">
					{{ Form::text('email',$userInfo->email,array('class'=>'form-control')) }}
				</div>
				<span class="form-feed-back">{{ $errors->first('email') }}</span>
			</div>
			{{ Form::hidden('signal','profile') }}
			<div class="col-md-4 offset4">
				{{ Form::submit('修改',array('class'=>'btn btn-primary')) }}
				{{ Form::reset('取消',array('class'=>'btn btn-cancel')) }}
			</div>
		{{ Form::close() }}
@stop