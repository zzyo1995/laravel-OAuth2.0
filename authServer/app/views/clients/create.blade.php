@extends('layouts.master')

@section('title')
@parent
:: 注册客户端
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
    <h2>注册客户端</h2>
</div>

{{ Form::open(array('url' => 'clients', 'class' => 'form-horizontal', 'role' => 'form')) }}
    <!-- 客户端id -->
    <div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
        {{ Form::label('id', '客户端id', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-star fa-fw"></i></span>
                {{ Form::text('id', Input::old('id'), array('class' => 'form-control')) }}
            </div>
        </div>
        <p class="col-sm-3 form-control-static text-danger">
            {{ $errors->first('id') }}
        </p>
    </div>
    
    <!-- 客户端类型 -->
    <div class="form-group">
    	<label class="col-sm-2 control-label" for="type">客户端类型</label>
    	<div class="col-sm-10" name="type">
	    	<label class="radio-inline">
	    		{{ Form::radio('client_type','client') }}
	    		客户端
	    	</label>
	    	<label class="radio-inline">
	    		{{ Form::radio('client_type','web') }}
	    		web
	    	</label>
    	</div>
    </div>
    
    <!-- web端重定向url -->
    <div class="form-group" id="redirect_url">
    	<label class="col-sm-2 control-label" for="redirect_url">重定向url</label>
    	<div class="col-sm-3">
    		<div class="input-group">
	            <span class="input-group-addon"><i class="fa fa-shield fa-fw"></i></span></span>
	            {{ Form::text('redirect_url','',array('class'=>'form-control','placeholder'=>'重定向url')) }}
        	</div>
    	</div>
    </div>

<!-- 客户端权限-->
<div class="form-group {{{ $errors->has('scope') ? 'has-error' : '' }}}">
    {{ Form::label('scope', '客户端权限', ['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-3">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-shield fa-fw"></i></span></span>
            {{ Form::select('scope', $scope_options, Input::old('scope'), ['class' => 'form-control']) }}
        </div>
    </div>
    <p class="col-sm-3 form-control-static text-danger">
        {{ $errors->first('scope') }}
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
