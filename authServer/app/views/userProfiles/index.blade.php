@extends('layouts.admin')

@section('title')
用户信息资源
@stop

@section('content')
		<h2 class="offset4">用户信息资源</h2>
		<hr />
		@if (isset($resourceInfo))
		{{ Form::open(array('url'=>'userProfiles/'.$resourceInfo->id,'method'=>'put','class'=>'form-horizontal offset4','role'=>'form')) }}
		<!-- 用户id -->
			<div class="form-group">
				<label class="control-label col-md-2" for="userId">用户id</label>
				<div class="col-md-4">
					{{ Form::text('userId',$resourceInfo->userId,array('class'=>'form-control','readonly'=>'true')) }}
				</div>
			</div>
			
		<!-- mobile -->
			<div class="form-group {{ isset($errors->address)?has-error:''}}">
				<label class="control-label col-md-2" for="mobile">联系电话</label>
				<div class="col-md-4">
					{{ Form::text('mobile',$resourceInfo->mobile,array('class'=>'form-control')) }}
				</div>
				<span class="form-feed-back">{{ $errors->first('mobile') }}</span>
			</div>
			
		<!-- address -->
			<div class="form-group {{ isset($errors->address)?has-error:'' }}">
				<label class="control-label col-md-2" for="address">联系地址</label>
				<div class="col-md-4">
					{{ Form::text('address',$resourceInfo->address,array('class'=>'form-control')) }}
				</div>
				<span class="form-feed-back">{{ $errors->first('address') }}</span>
			</div>
			
		<!-- age -->
			<div class="form-group {{ isset($errors->age)?has-error:'' }}">
				<label class="control-label col-md-2" for="age">年龄</label>
				<div class="col-md-4">
					{{ Form::text('age',$resourceInfo->age,array('class'=>'form-control')) }}
				</div>
				<span class="form-feed-back">{{ $errors->first('age') }}</span>
			</div>
			
			<div class="col-md-4 offset4">
				{{ Form::submit('修改',array('class'=>'btn btn-primary')) }}
				{{ Form::reset('取消',array('class'=>'btn btn-cancel')) }}
			</div>
		{{ Form::close() }}
		@else
			{{ Form::open(array('url'=>'userProfiles','method'=>'post','class'=>'form-horizontal offset4','role'=>'form')) }}
		<!-- 用户id -->
			<div class="form-group">
				<label class="control-label col-md-2" for="userId">用户id</label>
				<div class="col-md-4">
					{{ Form::text('userId',Auth::user()->id,array('class'=>'form-control','readonly'=>'true')) }}
				</div>
			</div>
			
		<!-- mobile -->
			<div class="form-group {{ isset($errors->address)?has-error:''}}">
				<label class="control-label col-md-2" for="mobile">联系电话</label>
				<div class="col-md-4">
					{{ Form::text('mobile','',array('class'=>'form-control')) }}
				</div>
				<span class="form-feed-back">{{ $errors->first('mobile') }}</span>
			</div>
			
		<!-- address -->
			<div class="form-group {{ isset($errors->address)?has-error:'' }}">
				<label class="control-label col-md-2" for="address">联系地址</label>
				<div class="col-md-4">
					{{ Form::text('address','',array('class'=>'form-control')) }}
				</div>
				<span class="form-feed-back">{{ $errors->first('address') }}</span>
			</div>
			
		<!-- age -->
			<div class="form-group {{ isset($errors->age)?has-error:'' }}">
				<label class="control-label col-md-2" for="age">年龄</label>
				<div class="col-md-4">
					{{ Form::text('age','',array('class'=>'form-control')) }}
				</div>
				<span class="form-feed-back">{{ $errors->first('age') }}</span>
			</div>
			
			<div class="col-md-4 offset4">
				{{ Form::submit('修改',array('class'=>'btn btn-primary')) }}
				{{ Form::reset('取消',array('class'=>'btn btn-cancel')) }}
			</div>
		{{ Form::close() }}
		@endif
@stop