@extends('layouts.master')

@section('title')
@parent
:: 更新用户信息
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
    <h2>更新用户信息</h2>
</div>
<ul class="nav nav-tabs">
	<li><a href="#user_info" data-toggle="tab">基本资料</a></li>
    <li  class="active"><a href="#user_image" data-toggle="tab">头像照片</a></li>
</ul>

<div class="tab-content">
	<div class="tab-pane active" id="user_image">
		<div class="row" style="margin-top:30px">
			{{ Form::open(array('url'=>'userDetial/userImageUploadFromWeb','id'=>'fileUploadForm','enctype'=>'multipart/form-data','class'=>'','role'=>'form','files'=>'true','name'=>'fileUploadForm')) }}
				<div class="form-group" >
					<label class="control-label col-md-2" for="filename">选择图片</label>
					<div class="col-md-2">
						{{Form::file('filename',array('class'=>'form-control','accept'=>'image/jpeg,image/jpg,image/png','style'=>'margin:0px;border:0px none rgb(255, 255, 255);box-shadow:0px 0px 0px'))}}
					</div>
				</div>
				<div class="col-md-4">
					{{ Form::submit('上传图片',array('class'=>'btn btn-primary')) }}			
				</div>
			{{ Form::close() }}
		</div>
		<div class="row" style="margin-top:30px">
			<div class="col-md-6" style="border:gray solid 1px;width:302px;height:402px;padding:0px;">
				{{ HTML::image('','用户头像图片',array('alt'=>'图片未选择,请上传图片','id'=>'user_face')) }}
				<p id="updateImage1">图片未上传，请上传图片</p>
			</div> 
	 		<div class="col-md-6" id="preview-pane" style="display: block;position:absolute;padding:6px;z-index:2000;margin-left:350px">
				<div class="preview-container" style="width:300px;height:300px;overflow:hidden;border:gray solid 1px">
					{{ HTML::image('','用户头像缩略图',array('alt'=>'图片未选择,请上传图片','id'=>'user_preview','class'=>'jcrop-preview')) }}
					<p id="updateImage2">图片未上传，请上传图片</p>
				</div>
			</div>
		</div>
		<div class="row" style="margin-top:20px">
			<div class="col-md-6 offset1">
				<button id="saveImg">保存头像</button>
			</div>
		</div>
	</div>
	<div class="tab-pane" id="user_info">
		{{ Form::open(array('url' => 'users/'.$user->id, 'method' => 'put', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data','role' => 'form','id'=>'userDetailInfoForm')) }}
		    <!-- 姓名
		    <div class="form-group">
		        {{ Form::label('username', '姓名', array('class' => 'col-sm-2 control-label')) }}
		        <p class="col-sm-3 form-control-static">
		            {{ $user->username }}
		        </p>
		    </div> -->
		
		    <!-- 邮箱 -->
		    <div class="form-group">
		        {{ Form::label('email', '电子邮件', array('class' => 'col-sm-2 control-label')) }}
		        <p class="col-sm-3 form-control-static">
		            {{ $user->email }}
		        </p>
		    </div>
		
		    <!-- 昵称 -->
		    <div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
		        {{ Form::label('name', '昵称', array('class' => 'col-sm-2 control-label')) }}
		        <div class="col-sm-3">
		            <div class="input-group">
		                <span class="input-group-addon"><span class="glyphicon glyphicon-flag"></span></span>
		                {{ Form::text('name', $user->name, array('class' => 'form-control')) }}
		            </div>
		        </div>
		        <p class="col-sm-3 form-control-static text-danger">
		            {{ $errors->first('name') }}
		        </p>
		    </div>
		    
			<!-- 性别 -->
		    <div class="form-group">
		    	{{ Form::label('sex','性别',array('class'=>'col-sm-2 control-label','for'=>'sexRadio')) }}
		    	<div class="col-sm-3" style="border:gray solid 0px;">
			    	<div id="sexRadio" name="sexRadio" class="form-control" style="border:gray solid 0px;box-shadow: inset 0 0px 0px rgba(0, 0, 0, 0)">
			    		@if ($user->sex != 1)
			    			<div class="col-sm-4">{{ Form::radio('sex','0',array('checked'=>'checked')) }} 男</div> 
			    			<div class="col-sm-4">{{ Form::radio('sex','1') }}女</div>
			    		@else
			    			<div class="col-sm-4">{{ Form::radio('sex','0') }} 男</div> 
			    			<div class="col-sm-4">{{ Form::radio('sex','1',array('checked'=>'checked')) }}女</div>
			    		@endif
			    	</div>
		    	</div>
		    </div>
		    
		    <!-- 家庭住址 -->
		    <div class="form-group">
		        {{ Form::label('address', '家庭住址', array('class' => 'col-sm-2 control-label')) }}
		        <div class="col-sm-3">
		            <div class="input-group">
		                <span class="input-group-addon"><span class="glyphicon glyphicon-flag"></span></span>
		                {{ Form::text('address', $user->address, array('class' => 'form-control','placeholder'=>'家庭住址')) }}
		            </div>
		        </div>
		    </div>
		    
		    <!-- 房间号 -->
		    <div class="form-group">
		        {{ Form::label('address', '房间号', array('class' => 'col-sm-2 control-label')) }}
		        <div class="col-sm-3">
		            <div class="input-group">
		                <span class="input-group-addon"><span class="glyphicon glyphicon-flag"></span></span>
		                {{ Form::text('room_number', $user->room_number, array('class' => 'form-control','placeholder'=>'房间号')) }}
		            </div>
		        </div>
		    </div>

		    <!-- 分机号 -->
		    <div class="form-group">
		        {{ Form::label('address', '分机号', array('class' => 'col-sm-2 control-label')) }}
		        <div class="col-sm-3">
		            <div class="input-group">
		                <span class="input-group-addon"><span class="glyphicon glyphicon-flag"></span></span>
		                {{ Form::text('extension_number', $user->extension_number, array('class' => 'form-control','placeholder'=>'分机号')) }}
		            </div>
		        </div>
		    </div>

		    <!-- 备注 -->
		    <div class="form-group">
		        {{ Form::label('address', '备注', array('class' => 'col-sm-2 control-label')) }}
		        <div class="col-sm-3">
		            <div class="input-group">
		                <span class="input-group-addon"><span class="glyphicon glyphicon-flag"></span></span>
		                {{ Form::text('remark', $user->remark, array('class' => 'form-control','placeholder'=>'备注')) }}
		            </div>
		        </div>
		    </div>

		    <!-- 联系方式 -->
		    <div class="form-group">
		        {{ Form::label('phone', '联系方式', array('class' => 'col-sm-2 control-label')) }}
		        <div class="col-sm-3">
		            <div class="input-group">
		                <span class="input-group-addon"><span class="glyphicon glyphicon-flag"></span></span>
		                {{ Form::text('phone', $user->phone, array('class' => 'form-control','placeholder'=>'联系方式')) }}
		            </div>
		        </div>
		    </div>
		    
		    <!-- 更新按钮 -->
		    <div class="form-group">
		        <div class="col-sm-offset-2 col-sm-3">
		            {{ Form::submit('更新', array('class' => 'btn btn-success')) }}
		        </div>
		    </div>
		    {{ Form::hidden('mode', 'update-profile') }}
		{{ Form::close() }}
	</div>
</div>
@stop
