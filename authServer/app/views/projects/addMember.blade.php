@extends('layouts.manage')
@section('title')
    @parent :: 项目组管理
@stop

{{--Content --}}

@section('caption')
    {{ $projectGroupName }}:添加成员
@stop

@section('content')
<div style="text-align: center">
	{{ Form::open(['url' => 'manage/projectGroup/searchUser','class' => 'form-horizontal','role' => 'form', 'method' => 'get']) }}
	{{ Form::text('name', Input::old('name'), ['class' => 'add_user_input']) }}
	{{ Form::hidden('id', $projectGroup_id) }}
	{{ Form::submit('人员查找', ['id' => 'sub','class' => 'btn btn-success']) }}	
	{{ Form::close() }}
</div>
{{ Form::open(['url' => 'manage/projectGroup/addMember' ,'class' => 'form-horizontal','role' => 'form', 'method' => 'post']) }}
    <div>
        <table class="table">
            <thead>
            <tr>
                <th><input type="checkbox" id="select_a" /></th>
                <th>用户名</th>
                <th>邮件地址</th>
                <th>联系方式</th>
            </tr>
            </thead>
            <tbody>

            @if($allUser[0] != null)

                @foreach($allUser as $user)
                    <tr>
                        <td><input type="checkbox" name="select_user" value="{{$user->id}}"/></td>
                        <td>{{$user->username}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->phone}}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
            <input type="hidden" name="project_group_id" value="{{$projectGroup_id}}" />
            <input type="hidden" name="project_group_name" value="{{$projectGroupName}}" />
            <input type="hidden" name="uid" id="uid">
            <input type="submit" class="btn btn-primary btn-sm" id="add_member"  value="添加"/>
    </div>
{{ Form::close() }}
@if($companyUsers != null)
    <div align="right">
        <?php
            echo $companyUsers->links();
        ?>
    </div>
@endif
@stop
