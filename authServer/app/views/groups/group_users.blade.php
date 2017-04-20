@extends('layouts.admin') 
@section('title') 
@parent :: 组成员管理
 @stop

{{--Content --}} 

@section('caption')
组 <small>{{ $group['name'] }}</small> 成员管理
@stop

@section('content') 
<div class="container">
	{{ Form::open(array('url' =>'admin/add_groupuser?group_id='.$group['id'])) }} {{
	Form::label('name', '添加用户到组', array('class' => 'col-sm-2 control-label')) }} 
	<select id="user" name="user"> 
	@foreach($ntusers as $ntuser)
		<option value="{{ $ntuser->id }}">{{$ntuser->username}}</option>
	@endforeach
	</select> &nbsp;&nbsp;&nbsp;
	<button type="submit" class="btn btn-primary btn-sm">添加</button>
	{{ Form::close() }}
</div>

<br />

<table class="table">
	<thead>
		<tr>
			<th>用户昵称</th>
			<th>邮箱</th>
			<th>删除</th>
		</tr>
	</thead>
	<tbody>
		@foreach($users as $user)
		<tr>
			<td>{{$user->username}}</td>
			<td>{{$user->email}}</td>
			<td>{{ Form::open(array('url' =>
				'admin/remove_groupuser?group_id='.$group['id'].'&user_id='.$user->id))
				}}
				<button type="submit" class="btn btn-danger btn-sm">删除</button> {{
				Form::close() }}
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
@stop
