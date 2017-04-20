@extends('layouts.admin')

@section('title')
添加资源文件
@stop

@section('content')
		<h2 class="offset4">添加资源文件</h2>
		<hr />
		{{ Form::open(array('url'=>'userFiles','class'=>'form-horizontal offset4','role'=>'form','files'=>'true','name'=>'fileUploadForm')) }}
			<div class="form-group {{ isset($errorInfo)?'has-error':'' }}">
				<label class="control-label col-md-2" for="filename">选择文件</label>
				<div class="col-md-2">
					{{Form::file('filename',array('class'=>'form-control','style'=>'margin:0px;border:0px none rgb(255, 255, 255);box-shadow:0px 0px 0px'))}}
				</div>
				<span class="form-feed-back">{{ isset($errorInfo)?$errorInfo:'' }}</span>
			</div>
			<div class="col-md-4 offset2">
				{{ Form::submit('上传文件',array('class'=>'btn btn-primary')) }}			
			</div>
		{{ Form::close() }}
@stop