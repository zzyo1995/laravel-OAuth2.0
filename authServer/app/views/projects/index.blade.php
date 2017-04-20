@extends('layouts.manage')
@section('title')
    @parent :: 项目组管理
@stop

{{--Content --}}
{{--
@section('caption')
项目组列表
@stop--}}

@section('content')

    <h1 style="text-align: center;">{{$companyName}}</h1>

    <div class="container" align="right">
        {{ Form::open(array('url' => 'manage/addGroupByName','method' => 'post')) }} {{
	    Form::label('name', '添加项目组', array('class' => 'control-label')) }}
        {{ Form::hidden('companyId', $companyId) }}
        {{ Form::hidden('companyName', $companyName) }}
        <select name="pid" style="width:120px;">
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
        {{ Form::open(array('url' =>'manage/addProjectGroup', 'method' => 'GET')) }}
        {{ Form::hidden('companyId', $companyId) }}
        {{ Form::hidden('companyName', $companyName) }}
        <button type="submit" class="btn btn-primary btn-sm">新建项目组</button>
        {{ Form::close() }}
    </div>

    <div style="width: 10px;height: 50px;"></div>

    <table class="table">
        <thead>
        <tr>
            <th>项目组ID</th>
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
                    {{ Form::hidden('projectGroup_name', $projectGroup->name) }}
                    {{ Form::hidden('companyId', $companyId) }}
                    {{ Form::hidden('companyName', $companyName) }}
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
                    {{ Form::open(array('url' =>'manage/projectGroup/' . $projectGroup->id, 'method' => 'POST'))}}

                    {{ Form::hidden('companyId', $companyId) }}
                    {{ Form::hidden('companyName', $companyName) }}

                    <button type="submit" onClick="return confirm('确认要删除？')" class="btn btn-danger btn-sm">删除</button>

                    {{ Form::close() }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
