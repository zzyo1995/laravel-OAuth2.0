@extends('layouts.admin')

@section('title')
获取认证服务器用户
@stop

@section('content')
<div class="row">
	<div class="col-md-4 offset4"><h2>获取认证服务器用户</h2></div>
	<div class="offset4" style="margin-bottom: 0px;padding:17px">
		<button class="btn btn-primary" id="resetResource">设置资源服务器</button>
		<button class="btn btn-primary" id="syncUsers">同步用户</button>
	</div>
</div>
<hr />
{{ Form::open(array('url'=>'insertResourceInfo','class'=>'form-horizontal offset4','style'=>isset($fail)?"":"display:none",'id'=>'resourceForm','role'=>'form')) }}
	<div class="form-group">
		<label class="col-md-2 control-label" for="server_ip">认证服务器地址：</label>
		<div class="col-md-4">
			{{ Form::text('server_ip','',array('class'=>'form-control','placeholder'=>'认证服务器ip地址或域名')) }}
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label" for="source_name">资源服务器名称：</label>
		<div class="col-md-4">
			{{ Form::text('source_name','',array('class'=>'form-control','placeholder'=>'资源服务器名称')) }}
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label" for="password">资源服务器密码：</label>
		<div class="col-md-4">
			{{ Form::password('password',array('class'=>'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label" for="password_confirmation">密码确认：</label>
		<div class="col-md-4">
			{{ Form::password('password_confirmation',array('class'=>'form-control')) }}
		</div>
	</div>
	<div class="offset4">
		{{ Form::submit('提交',array('class'=>'btn btn-primary')) }}
		{{ Form::reset('提交',array('class'=>'btn btn-cancel')) }}
	</div>
{{ Form::close() }}
@stop