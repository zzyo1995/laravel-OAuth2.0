@extends('layouts.admin')

@section('title')
	系统权限管理页面
@stop

@section('caption')
    系统权限管理
    <div class="col-xs-3 pull-right">
    	<button class="btn btn-primary" data-toggle="modal" data-target="#scopeModal">添加</button>
    </div>
@stop

@section('content')
	{{ Form::open(array('url'=>'#','method'=>'post','class'=>'form','role'=>'form')) }}
		<table id ="scopeTable" class="table">
		  <tr>
		    <th>id</th>
		    <th>权限类型</th>
		    <th>权限名称</th>
		    <th>权限描述</th>
		    <th>删除</th>
		  </tr>
		  @foreach ($scopes as $scope)
		  	<tr>
		  		<td>{{$scope->id}}</td>
		  		
		  		@if ($scope->scope === "user" || $scope->scope === "basic")
			  		<td style="height:34px;padding:0px">{{ Form::text('scope',$scope->scope,array('class'=>'form-control','style'=>'background-color:rgb(241,241,241);border:0px solid rgb(241,241,241);width:60px','readonly'=>true,'data-toggle'=>'tooltip','title'=>'系统内置权限，不能修改')) }}</td>
			  		<td style="height:34px;padding:0px">{{Form::text('name',$scope->name,array('class'=>'form-control','style'=>'background-color:rgb(241,241,241);border:0px solid rgb(241,241,241);width:100px','readonly'=>true,'data-toggle'=>'tooltip','title'=>'系统内置权限，不能修改'))}}</td>
			  		<td style="height:34px;padding:0px">{{Form::text('description',$scope->description,array('class'=>'form-control','style'=>'background-color:rgb(241,241,241);border:0px solid rgb(241,241,241);width:100px','readonly'=>true,'data-toggle'=>'tooltip','title'=>'系统内置权限，不能修改')) }}</td>
			  		<td style="height:34px;padding:0px"><div data-toggle='tooltip' title='系统内置权限，不能删除'>{{Form::button('删除',array('class'=>'btn btn-danger btn-sm','disabled'=>false))}}</div></td>
		  		@else
		  			<td style="height:34px;padding:0px">{{ Form::text('scope',$scope->scope,array('class'=>'form-control','style'=>'background-color:rgb(241,241,241);border:0px solid rgb(241,241,241)')) }}</td>
		  			<td style="height:34px;padding:0px">{{Form::text('name',$scope->name,array('class'=>'form-control','style'=>'background-color:rgb(241,241,241);border:0px solid rgb(241,241,241)'))}}</td>
			  		<td style="height:34px;padding:0px">{{Form::text('description',$scope->description,array('class'=>'form-control','style'=>'background-color:rgb(241,241,241);border:0px solid rgb(241,241,241)')) }}</td>
			  		<td style="height:34px;padding:0px">{{Form::button('删除',array('name'=>'scopeDelBtn','class'=>'btn btn-danger btn-sm'))}}</td>
		  		@endif
		  	</tr>
		  @endforeach
		</table>
	{{Form::close()}}

<!-- Modal -->
<div class="modal fade" id="scopeModal" tabindex="-1" role="dialog" aria-labelledby="scopeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="scopeModalLabel">权限添加</h4>
      </div>
      <div class="modal-body">
        {{Form::open(array('url'=>'','class'=>'form-horizontal','role'=>'form','id'=>'scopeAddForm'))}}
        	<div class="form-group">
        		<label class="control-label col-xs-2" for="scope">类型</label>
        		<div class="col-xs-6">
        		{{Form::text('scope','',array('id'=>'scope','placeholder'=>'类型','class'=>'form-control'))}}
        		</div>
        	</div>
        	<div class="form-group">
        		<label class="control-label col-xs-2" for="name">名称</label>
        		<div class="col-xs-6">
        		{{Form::text('name','',array('id'=>'name','placeholder'=>'名称','class'=>'form-control'))}}
        		</div>
        	</div>
        	<div class="form-group">
        		<label class="control-label col-xs-2" for="description">描述</label>
        		<div class="col-xs-6">
        		{{Form::text('description','',array('id'=>'description','placeholder'=>'描述','class'=>'form-control'))}}
        		</div>
        	</div>
        {{Form::close()}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" id="scopeAdd" class="btn btn-primary">添加</button>
      </div>
    </div>
  </div>
</div>
@stop
