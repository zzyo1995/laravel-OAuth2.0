@extends('layouts.admin')

@section('title')
资源服务器管理
@stop

@section('content')
<h2>资源服务器列表</h2>
<hr />
<div id="all">
	<table id="allResourceTable" class="table">
		<thead>
			<tr>
				<th>资源服务器名</th>
				<th>资源服务器状态</th>
				<th>修改</th>
				<th>资源服务器注册时间</th>
				<th>备注</th>
				<th>删除</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($attServers as $eachServer)
			<tr>
				<td>{{$eachServer->name}}</td>
				@if ($eachServer->status == 0)
						<td>{{ "未审批" }}</td>
					@elseif ($eachServer->status == 1)
						<td>{{ "审批成功" }}</td>
					@else
						<td>{{ "审批失败" }}</td>
					@endif
				
				<td>{{Form::button('修改',array('class'=>'btn btn-parmary','data-toggle'=>'modal','data-target'=>'#myModal'))}}</td>
				<td>{{$eachServer->created_at}}</td>
				<td>{{$eachServer->reason}}</td>
				<td>删除</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>


	
	<!-- 模态对话框 -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">资源服务器信息修改</h4>
      </div>
      <div class="modal-body">
        {{Form::open(array('url'=>'testAjax','class'=>'form-horizontal','role'=>'form','id'=>'resourceForm'))}}
        	<!-- resource server name -->
        	<div class="form-group">
        		<label class="control-label col-md-4" for="name">资源服务器名称</label>
        		<div class="col-md-6">
        			{{ Form::text('name','123',array('class'=>'form-control','readonly'=>'true')) }}
        		</div>
        	</div>
        	<div class="form-group">
        		<label class="control-label col-md-4" for="status">资源服务器状态</label>
        		<div class="col-md-6">
        			{{ Form::select('status',array('success'=>'审批成功','fail'=>'审批失败','undo'=>'未审批'),array('class'=>'form-control')) }}
        		</div>
        	</div>
        	<div class="form-group">
        		<label class="control-label col-md-4" for="created_at">资源服务器注册时间</label>
        		<div class="col-md-6">
        			{{ Form::text('created_at','123',array('class'=>'form-control','readonly'=>'true')) }}
        		</div>
        	</div>
        	<div class="form-group">
        		<label class="control-label col-md-4" for="reason">资源服务器备注</label>
        		<div class="col-md-6">
        			{{ Form::textarea('reason','',array('class'=>'form-control','placeholder'=>'备注信息')) }}
        		</div>
        	</div>
        {{Form::close()}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" id="submitBtn" class="btn btn-primary">保存修改</button>
      </div>
    </div>
  </div>
</div>
	
@stop