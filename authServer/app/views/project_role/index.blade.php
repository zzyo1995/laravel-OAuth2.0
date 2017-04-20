@extends('layouts.admin')

@section('title')
    项目组组内角色
@stop

@section('caption')
    项目组组内角色管理
    <div class="col-xs-3 pull-right">
        {{ Form::open(array('url'=>'project_role/add','method'=>'GET')) }}
        <button class="btn btn-primary">创建组内角色</button>
        {{Form::close()}}
    </div>
@stop

@section('content')
    <table id="roleTable" class="table">
        <tr>
            <th>id</th>
            <th>名称</th>
            <th>值</th>
            <th>修改</th>
            <th></th>
        </tr>
        @foreach ($roles as $role)
            <tr>
                <td>{{$role->id}}</td>
                <td>{{$role->name}}</td>
                <td>{{$role->value}}</td>
                <td>
                    {{ Form::open(['url' => 'project_role/changeInfo/'.$role->id, 'method' => 'get']) }}
                    <button type="submit" class="btn btn-primary btn-sm">修改</button>
                    {{ Form::close() }}
                </td>
                <td>
                    {{ Form::open(['url' => 'project_role/delete/'.$role->id, 'method' => 'post']) }}
                    <button type="submit" onClick="return confirm('确认要删除？')" class="btn btn-danger btn-sm">删除</button>
                    {{ Form::close() }}
                </td>
            </tr>
        @endforeach
    </table>
@stop
