@extends('layouts.manage')
@section('title')
    @parent :: 项目组管理
@stop

{{--Content --}}

@section('caption')
    {{$projectGroupName}}子项目组列表
@stop

@section('content')
    <div class="container" align="right">
        {{ Form::open(array('url' => 'manage/addSonByName','method' => 'post')) }} {{
	    Form::label('name', '添加子项目组', array('class' => 'control-label')) }}
        {{ Form::hidden('projectGroupName', $projectGroupName) }}
        {{ Form::hidden('companyId', $companyId) }}
        {{ Form::hidden('superId', $superId) }}
        <select name="pg_id" style="width:120px;">
            @foreach ($allNoOwnerGroups as $allNoOwnerGroup)
                <option value={{ $allNoOwnerGroup->id }}>{{{ $allNoOwnerGroup->name }}}</option>
            @endforeach
        </select> &nbsp;&nbsp;&nbsp;
        @if($allNoOwnerGroups == null)
            <button type="submit" disabled="disabled" class="btn btn-primary btn-sm">添加</button>
        @else
            <button type="submit" class="btn btn-primary btn-sm">添加</button>
        @endif
        {{ Form::close() }}
    </div>

    <br/>

    <div class="container" align="right">
        {{ Form::open(array('url' =>'manage/addSonProjectGroup', 'method' => 'GET')) }}
        {{ Form::hidden('companyId', $companyId) }}
        {{ Form::hidden('companyName', $companyName) }}
        {{ Form::hidden('superId', $superId) }}

        <button type="submit" class="btn btn-primary btn-sm">新建子项目组</button>
        {{ Form::close() }}
    </div>

    <br/>

    <table class="table">
        <thead>
        <tr>
            <th>子项目组ID</th>
            <th>项目组名</th>
            <th>修改组信息</th>
            <th>子项目组管理</th>
            <th>成员管理</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($projectGroups as $projectGroup)
            <tr>
                <td>{{$projectGroup->id}}</td>
                <td>{{$projectGroup->name}}</td>
                <td>
                    {{ Form::open(array('url' =>'manage/chProjectGroup', 'method' => 'GET')) }}
                    {{ Form::hidden('companyId', $companyId) }}
                    {{ Form::hidden('projectGroupId', $projectGroup->id) }}
                    {{ Form::hidden('companyName', $companyName) }}
                    <button type="submit" class="btn btn-primary btn-sm">修改组信息</button>
                    {{ Form::close() }}
                </td>
                <td>
                    {{ Form::open(array('url' =>'manage/projectGroup/sonGroups', 'method' => 'GET'))}}
                    {{ Form::hidden('superId', $projectGroup->id) }}
                    {{ Form::hidden('companyId', $companyId) }}
                    {{ Form::hidden('projectGroup_name', $projectGroup->name) }}
                    <button type="submit" class="btn btn-primary btn-sm">管理</button>
                    {{ Form::close() }}
                </td>
                <td>
                    {{ Form::open(array('url' =>'manage/projectGroup/member', 'method' => 'GET'))}}
                    {{ Form::hidden('projectGroup_id', $projectGroup->id) }}
                    {{ Form::hidden('projectGroup_name', $projectGroup->name) }}
                    <button type="submit" class="btn btn-primary btn-sm">管理</button>
                    {{ Form::close() }}
                </td>
                <td>
                    {{ Form::open(array('url' =>'manage/projectSonGroup/' . $projectGroup->id, 'method' => 'POST'))}}
                    {{ Form::hidden('companyId', $companyId) }}
                    {{ Form::hidden('projectGroup_name', $projectGroup->name) }}
                    <button type="submit" onClick="return confirm('确认要删除？')" class="btn btn-danger btn-sm">删除</button>
                    {{ Form::close() }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
