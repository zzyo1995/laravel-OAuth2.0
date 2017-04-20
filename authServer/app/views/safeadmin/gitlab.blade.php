@extends('layouts.safeadmin')

@section('title')
    gitlab < @parent
@stop

{{-- Content --}}
@section('caption')
    gitlab
@stop
@section('content')
    <div class="container">
        {{ Form::open(array('url' => 'safeadmin/add_juris_user/gitlab','method' => 'post')) }} {{
	    Form::label('name', '添加到修改列表', array('class' => 'control-label')) }}
        <select name="user_id" style="width:90px;">
            @foreach ($ntclients as $ntclient)
                <option value={{ $ntclient->user_id }}>{{{ $ntclient->username }}}</option>
            @endforeach
        </select> &nbsp;&nbsp;&nbsp;
        @if($ntclients == null)
            <button type="submit" disabled="disabled" class="btn btn-primary btn-sm">添加</button>
        @else
            <button type="submit" class="btn btn-primary btn-sm">添加</button>
        @endif
        {{ Form::close() }}
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>用户名称</th>
            <th>邮箱</th>
			<th>所属组长</th>
            <th>密级</th>
            <th>用户权限</th>
            <th>代码仓库权限</th>
            <th>用户权限Jira</th>
            <th>修改</th>
            <th>移除</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($clients as $client)
            <tr>
                {{ Form::open(array('url' => 'safeadmin/change_juris/'.$client->id.'/gitlab', 'method' => 'post')) }}
                <td>{{{ $client->username }}}</td>
                <td>{{{ $client->email }}}</td>
				<td>
				<?php
				$gm = DB::table('project_group_member')
               	->join('users', 'users.id', '=', 'project_group_member.user_id')
                ->where('users.id', $client->id)->pluck('project_group_id');
				$ms = DB::table('project_group_member')
				->where('project_group_member.project_group_id', $gm)
				->where('project_group_member.type', 1)->pluck('user_id');
				$m = DB::table('users')
				->where('users.id', $ms)->pluck('username');
				echo $m;
				?>
				</td>
                <td>
                    <select name="miji">
                        @if($client->miji == "1")
                            <option selected= "selected" value="1">level1</option>
                        @else
                            <option value="1">level1</option>
                        @endif
                        @if($client->miji == "2")
                            <option selected= "selected" value="2">level2</option>
                        @else
                            <option value="2">level2</option>
                        @endif
                        @if($client->miji == "3")
                            <option selected= "selected" value="3">level3</option>
                        @else
                            <option value="3">level3</option>
                        @endif
                        @if($client->miji == "4")
                            <option selected= "selected" value="4">level4</option>
                        @else
                            <option value="4">level4</option>
                        @endif
                        @if($client->miji == "5")
                            <option selected= "selected" value="5">level5</option>
                        @else
                            <option value="5">level5</option>
                        @endif
                    </select>
                </td>
                <td>
                    <select name="usersjuris">
                        @if($client->usersjuris == "checker")
                            <option selected= "selected" value="checker">审核员</option>
                        @else
                            <option value="checker">审核员</option>
                        @endif
                        @if($client->usersjuris == "administrator")
                            <option selected= "selected" value="administrator">管理员</option>
                        @else
                            <option value="administrator">管理员</option>
                        @endif
                        @if($client->usersjuris == "user")
                            <option selected= "selected" value="user">用户</option>
                        @else
                            <option value="user">用户</option>
                        @endif
                    </select>
                </td>
                <td>
                    <select name="codejuris">
                        @if($client->codejuris == "guest")
                            <option selected= "selected" value="guest">Guest</option>
                        @else
                            <option value="guest">Guest</option>
                        @endif
                        @if($client->codejuris == "reporter")
                            <option selected= "selected" value="reporter">Reporter</option>
                        @else
                            <option value="reporter">Reporter</option>
                        @endif
                        @if($client->codejuris == "developer")
                            <option selected= "selected" value="developer">Developer</option>
                        @else
                            <option value="developer">Developer</option>
                        @endif
                        @if($client->codejuris == "master")
                            <option selected= "selected" value="master">Master</option>
                        @else
                            <option value="master">Master</option>
                        @endif
                        @if($client->codejuris == "owner")
                            <option selected= "selected" value="owner">Owner</option>
                        @else
                            <option value="owner">Owner</option>
                        @endif
                    </select>
                </td>
                <td>
                    <select name="users_jira_juris">
                        @if($client->users_jira_juris == "user")
                            <option selected= "selected" value="user">User</option>
                        @else
                            <option value="user">User</option>
                        @endif
                        @if($client->users_jira_juris == "administrator")
                            <option selected= "selected" value="administrator">Administrator</option>
                        @else
                            <option value="administrator">Administrator</option>
                        @endif
                        @if($client->users_jira_juris == "developer")
                            <option selected= "selected" value="developer">Developer</option>
                        @else
                            <option value="developer">Developer</option>
                        @endif
                    </select>
                </td>
                <td>
                    <button type="submit" class="btn btn-primary btn-sm">修改</button>
                </td>
                {{ Form::close() }}
                <td>
                    {{ Form::open(array('url' =>
                    'safeadmin/remove_juris_user/'.$client->id.'/gitlab','method' => 'post'))
                    }}
                    <button type="submit" class="btn btn-danger btn-sm">移除</button> {{
				    Form::close() }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    </div>
@stop
