@extends('layouts.admin')

@section('title')
客户端管理 < @parent
@stop

{{-- Content --}}
@section('caption')
组列表&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary btn-sm" href="{{URL::to('admin/group-create')}}">新建组</a>
@stop
@section('content')
	<script type="text/javascript">
$(function() {  
    $('#test').tooltip({})   
});  
</script>
<div>
    <table class="table">
        <thead>
        <tr>
            <th>id</th>
            <th>名称</th>
            <th>权限</th>
            <th>描述</th>
            <th>删除</th>
            <th>修改</th>
            <th>成员管理</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($groups as $group)
        <tr>
            <td>{{{ $group->id }}}</td>
            <td>{{{ $group->name }}}</td>
            <td>
            	@foreach ($scopes as $scope)
            		@if (strstr($group->privileges,$scope->scope))
            			{{{$scope->description}}} &nbsp;&nbsp;
            		@endif
            	@endforeach
             </td>
            <td>{{{ $group->description }}}</td>
            <td>
               {{ Form::open(['url' => 'groups/'.$group->id, 'method' => 'delete']) }}
               		@if ( $group->name === "ordinary" || $group->name === "admin" )
               			<div data-toggle="tooltip" data-placement="bottom" id="test" title="系统内置组，不能删除">
	                		<button type="submit" class="btn btn-danger btn-sm" disabled="disabled">删除</button>
	                	</div>
	                @else
	                	@if($group->hasUsers === true)
	                		<div data-toggle="tooltip" data-placement="bottom" id="test" title="组成员非空，不能删除">
	                		<button type="submit" class="btn btn-danger btn-sm" disabled="disabled">删除</button>
	                		</div>
	                	@else
	                		<button type="submit" class="btn btn-danger btn-sm">删除</button>
	                	@endif
	                	
	                @endif
		       {{ Form::close() }}
            </td>
            <td>
                {{ Form::open(['url' => 'groups/'.$group->id.'/edit', 'method' => 'get']) }}
                	@if ( $group->name === "ordinary" || $group->name === "admin" )
                		<div data-toggle="tooltip" data-placement="bottom" id="test" title="系统内置组，不能修改">
	                		<button type="submit" class="btn btn-primary btn-sm" disabled="disabled">修改</button>
	                	</div>
	                	
	                @else
	                	<button type="submit" class="btn btn-primary btn-sm" >修改</button>
	                @endif
		        {{ Form::close() }}
            </td>
            <td>
                	{{ Form::open(['url' => 'groups/'.$group->id, 'method' => 'get']) }}
	                <button type="submit" class="btn btn-primary btn-sm">查看</button>
		        {{ Form::close() }}
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
