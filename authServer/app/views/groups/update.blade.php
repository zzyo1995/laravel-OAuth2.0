@extends('layouts.admin')

@section('title')
@parent
:: 修改用户组
@stop
{{-- Content --}}
@section('caption')
修改用户组信息
@stop
@section('content')

{{ Form::open(array('url' => 'groups/'.$group_info['id'], 'class' => 'form-horizontal', 'role' => 'form','method' => 'put')) }}
    <!-- 用户组名称 -->
    <div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
        {{ Form::label('name', '用户组名称', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-quote-left fa-fw"></i></span></span>
                {{ Form::text('name', $group_info['name'], array('class' => 'form-control','placeholder'=>'groupname')) }}
            </div>
        </div>
        <p class="col-sm-3 form-control-static text-danger">
            {{ $errors->first('name') }}
        </p>
    </div>

<!-- 客户端权限-->
<div class="form-group {{{ $errors->has('privileges') ? 'has-error' : '' }}}">
    {{ Form::label('scope', '用户权限', ['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-3">
    @foreach ($scopes as $scope)
    	<div class="checkbox-inline">
	      <label>
	      	@if (strstr($group_info['privileges'],$scope->scope))
	      		{{Form::checkbox('privileges[]',$scope->scope,true)}} {{$scope->description}}
	      	@else
	      		{{Form::checkbox('privileges[]',$scope->scope)}}{{$scope->description}}
	      	@endif
	      </label>
	   </div>
    @endforeach
    <!-- 
    	@if ( strstr($group_info['privileges'],"users") != null)
        	<label class="radio-inline">
		 		 <input type="radio" name="privileges" value="users" checked="true"> 是
		 	</label>
		 	<label class="radio-inline">
		 		 <input type="radio" name="privileges" value="basic"> 否
		 	</label>
		 	@else
		 		<label class="radio-inline">
			 		 <input type="radio" name="privileges" value="users"> 是
			 	</label>
			 	<label class="radio-inline">
			 		 <input type="radio" name="privileges" value="basic"  checked="true"> 否
			 	</label>
		 	@endif
		</label>
	 -->
    </div>
    <p class="col-sm-3 form-control-static text-danger">
        {{ $errors->first('privileges') }}
    </p>
</div>

<!-- 组描述-->
<div class="form-group {{{ $errors->has('description') ? 'has-error' : '' }}}">
    {{ Form::label('description', '用户组描述', ['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-3">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-shield fa-fw"></i></span></span>
            {{ Form::text('description', $group_info['description'], array('class' => 'form-control','placeholder'=>'group description')) }}
        </div>
    </div>
    <p class="col-sm-3 form-control-static text-danger">
        {{ $errors->first('description') }}
    </p>
</div>

<!-- 注册按钮 -->
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-3">
        {{ Form::submit('修改', array('class' => 'btn btn-success')) }}
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