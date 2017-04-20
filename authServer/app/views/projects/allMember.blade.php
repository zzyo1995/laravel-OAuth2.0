@extends('layouts.manage')
@section('title')
    @parent :: 项目组管理
@stop

{{--Content --}}

@section('caption')
    {{ $projectGroupName }}:项目组成员
@stop

@section('content')
    <div class="container">
	    {{ Form::open(array('url' =>'manage/projectGroup/addMember/'.$projectGroupId, 'method' => 'GET')) }}
	        {{ Form::hidden('projectGroup_id', $projectGroupId) }}
	        <button type="submit" class="btn btn-primary btn-sm">添加成员</button>
	    {{ Form::close() }}
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>成员</th>
            <th>用户邮箱</th>
            <th>用户类型</th>
            <th>联系电话</th>
            <th>角色</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @if($userInfo[0] != null)

        @foreach($userInfo as $user)
            <tr>
                <td>{{$user['username']}}</td>
                <td>{{$user['email']}}</td>
                <td>{{$user['user_category']}}</td>
                <td>{{$user['phone']}}</td>
                {{ Form::open(array('url' =>'manage/projectGroup/changeProjectRole', 'method' => 'POST'))}}
                <td>
                    <select name="type">
                    @foreach ($projectRoles as $projectRole)
                    		@if ($projectRole->value == $user['type'])
                            	<option selected= "selected" value={{ $projectRole->value }}>{{ $projectRole->name }}</option>
                            @else
                            	<option value={{ $projectRole->value }}>{{ $projectRole->name }}</option>
                            @endif
                    @endforeach
                    </select>
                    {{ Form::hidden('userId', $user['id']) }}
                    {{ Form::hidden('projectGroup_id', $projectGroupId) }}
                    {{ Form::hidden('projectGroup_name', $projectGroupName) }}
                    <button type="submit" class="btn btn-primary btn-sm">修改</button>
                    {{ Form::close() }}
                </td>
                <td>
                    {{ Form::open(array('url' =>'manage/projectGroup/deleteMember', 'method' => 'POST'))}}
                    {{ Form::hidden('userId', $user['id']) }}
                    {{ Form::hidden('projectGroup_id', $projectGroupId) }}
                    <button type="submit" onClick="return confirm('确认要删除？')" class="btn btn-danger btn-sm">删除</button>
                    {{ Form::close() }}
                </td>
            </tr>
        @endforeach
        @endif
        </tbody>
    </table>
@stop
