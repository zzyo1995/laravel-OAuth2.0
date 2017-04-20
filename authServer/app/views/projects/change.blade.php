@extends('layouts.manage')
@section('title')
修改组信息  < @parent
@stop
{{-- Content --}}
@section('caption')
修改组信息
@stop
@section('content')

{{ Form::open(array('url' => 'manage/chProjectGroup', 'class' => 'form-horizontal','role' => 'form' , 'method' => 'POST')) }}
<!-- 用户组名称 -->
<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
	{{ Form::label('name', '项目组名称', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-3">
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-quote-left fa-fw"></i></span>
			{{ Form::text('name', Input::old('name'), array('class' =>'form-control','placeholder'=>'project’s name')) }}
		</div>
	</div>
	<p class="col-sm-3 form-control-static text-danger">{{
		$errors->first('name') }}</p>
</div>
<div class="form-group {{ $errors->has('enname') ? 'has-error' : '' }}">
	{{ Form::label('enname', '项目组英文名称', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-3">
                
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-quote-left fa-fw"></i></span>
        
			{{ Form::text('enname', Input::old('enname'), array('class' =>'form-control','placeholder'=>'project_enname')) }}
                 
		</div>
                             
	</div>
       
	<p class="col-sm-3 form-control-static text-danger">{{
		$errors->first('enname') }}</p>
</div>
<div class="form-group {{ $errors->has('leaf') ? 'has-error' : '' }}">
	{{ Form::label('leaf', '叶子组', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-3">
                
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-quote-left fa-fw"></i></span>
        
			{{ Form::text('leaf', Input::old('leaf'), array('class' =>'form-control','placeholder'=>'叶子组输入1, 非叶子组输入0')) }}
                 
		</div>
                             
	</div>
       
	<p class="col-sm-3 form-control-static text-danger">{{
		$errors->first('leaf') }}</p>
</div>
{{ Form::hidden('projectGroupId', $projectGroupId) }}
{{ Form::hidden('companyId', $companyId) }}
{{ Form::hidden('companyName', $companyName) }}
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-3">{{ Form::submit('修改',array('class' => 'btn btn-success')) }}</div>
</div>

{{ Form::close() }}
@stop
