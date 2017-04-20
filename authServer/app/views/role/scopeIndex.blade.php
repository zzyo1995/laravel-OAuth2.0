@extends('layouts.admin')
@section('title')
    @parent :: 权限管理
@stop

{{--Content --}}

@section('caption')
    权限列表
@stop

@section('content')
    <div align="center">
        {{ Form::open(array('url' => 'role/addScope','method' => 'POST')) }}
        {{ Form::label('name', '添加权限', array('class' => 'control-label')) }}
        {{ Form::hidden('roleId', $roleId) }}
        <select name="scopeId" style="width:120px;">
            @foreach ($allScopes as $perScope)
                <option value={{ $perScope->id }}>{{{ $perScope->name }}}</option>
            @endforeach
        </select> &nbsp;&nbsp;&nbsp;
        @if($allScopes == null)
            <button type="submit" disabled="disabled" class="btn btn-primary btn-sm">添加</button>
        @else
            <button type="submit" class="btn btn-primary btn-sm">添加</button>
        @endif
        {{ Form::close() }}
    </div>

    <br/>

    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>权限名称</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($Scopes as $Scope)
            <tr>
                <td>{{$Scope->id}}</td>
                <td>{{$Scope->name}}</td>
                <td>
                    {{ Form::open(array('url' =>'role/deleteScope', 'method' => 'POST'))}}
                    {{ Form::hidden('roleId', $roleId) }}
                    {{ Form::hidden('scopeId', $Scope->id) }}
                    <button type="submit" onClick="return confirm('确认要删除？')" class="btn btn-danger btn-sm">删除</button>
                    {{ Form::close() }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
