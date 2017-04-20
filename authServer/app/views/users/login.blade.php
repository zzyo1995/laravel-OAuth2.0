@extends('layouts.main')

@section('title')
用户登陆
@stop

@section('content')

<div class="offset5">
	<h2>用户登陆</h2>
</div>
<hr />
<div class="col-md-3 offset5">
	{{ Form::open(array('url'=>'login_post','class'=>'form-horizontal','role'=>'role')) }}
	<!-- 用户名 -->
		<div class="form-group">
			<label class="col-md-2 control-label" for="username">用户名</label>
			<div class="col-md-7">
				{{ Form::text('username','',array('class'=>'form-control','placeholder'=>'username')) }}
			</div>
		</div>
	<!-- 密码 -->
		<div class="form-group">
			<label class="col-md-2 control-label" for="password">密码</label>
			<div class="col-md-7">
				{{ Form::password('password',array('class'=>'form-control')) }}
			</div>
		</div>
		<!-- 提交按钮 -->
		<div class="offset4 offset2">
			{{ Form::submit('登陆',array('class'=>'btn btn-primary')) }}
			{{ Form::reset('取消',array('class'=>'btn btn-cancel')) }}
		</div>
	{{ Form::close() }}
</div>
<div class="col-md-2">
	<img src="img/logo.jpg" id="netaccount_login" style="width:50px;height:42px;border:1px solid black;margin-left:15px" class="btn"></img><br />
	<span style="margin-left: 0px">网络账号登陆</span>
</div>
@stop
