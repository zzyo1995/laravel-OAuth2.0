@extends('layouts.admin')
@section('title')
创建新用户组  < @parent
@stop
{{-- Content --}}
@section('caption')
创建新用户组
@stop
@section('content')
{{ Form::open(array('url' => 'groups', 'class' => 'form-horizontal','role' => 'form')) }}
<!-- 用户组名称 -->
<div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
	{{ Form::label('name', '用户组名称', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-3">
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-quote-left fa-fw"></i></span></span>
			{{ Form::text('name', Input::old('name'), array('class' =>'form-control','placeholder'=>'groupname')) }}
		</div>
	</div>
	<p class="col-sm-3 form-control-static text-danger">{{
		$errors->first('name') }}</p>
</div>

<!-- 客户端权限-->
<div class="form-group {{{ $errors->has('privileges') ? 'has-error' : '' }}}">
	{{ Form::label('scope', '后台管理权限', ['class' => 'col-sm-2 control-label'])}}
	<div class="col-sm-3">
			<!--              <span class="input-group-addon"><i class="fa fa-shield fa-fw"></i></span></span>
           {{ Form::text('privileges', Input::old('privileges'), array('class' => 'form-control','placeholder'=>'用户组权限')) }} 
            	<select name="privileges123" multiple="multiple" class="form-control" >
            		<option value="basic">普通权限</option>
            		<option value="users">管理员权限</option>
            	</select>-->
            	<label class="radio-inline">
				  <input type="radio" name="privileges" value="users"> 是
				</label>
				<label class="radio-inline">
				  <input type="radio" name="privileges" value="basic"> 否
	</div>
	<p class="col-sm-3 form-control-static text-danger">{{
		$errors->first('privileges') }}</p>
</div>

<!-- 组描述-->
<div
	class="form-group {{{ $errors->has('description') ? 'has-error' : '' }}}">
	{{ Form::label('description', '用户组描述', ['class' => 'col-sm-2 control-label']) }}
	<div class="col-sm-3">
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-shield fa-fw"></i></span></span>
			{{ Form::text('description', Input::old('description'), array('class' => 'form-control','placeholder'=>'group description')) }}
		</div>
	</div>
	<p class="col-sm-3 form-control-static text-danger">{{
		$errors->first('description') }}</p>
</div>
<!-- 注册按钮 -->
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-3">{{ Form::submit('新建',array('class' => 'btn btn-success')) }}</div>
</div>

<!-- 测试用 -->
<!--{{ Form::hidden('access_token', '11bBY7avOXmDMY3zygcYxUSrJdiAImhnPtgU3nVn') }}-->

{{ Form::close() }} 
@stop
<!-- 注册按钮 -->
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-3">{{ Form::submit('注册',
		array('class' => 'btn btn-success')) }}</div>
</div>

<!-- 测试用 -->
<!--{{ Form::hidden('access_token', '11bBY7avOXmDMY3zygcYxUSrJdiAImhnPtgU3nVn') }}-->

{{ Form::close() }} 
@stop
