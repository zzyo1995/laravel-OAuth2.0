@extends('layouts.admin')

@section('title')
    系统角色管理页面
@stop

@section('caption')
    系统角色管理
    <div class="col-xs-3 pull-right">
        {{ Form::open(array('url'=>'role/add','method'=>'GET')) }}
        <button class="btn btn-primary">创建角色</button>
        {{Form::close()}}
    </div>
@stop

@section('content')
    {{ Form::open(array('url'=>'#','method'=>'post','class'=>'form','role'=>'form')) }}
    <table id="roleTable" class="table">
        <tr>
            <th>id</th>
            <th>角色名称</th>
            <th>角色描述</th>
            <th>权限管理</th>
            <th>删除</th>
        </tr>
        @foreach ($roles as $role)
            <tr>
                <td>{{$role->id}}</td>
                <td style="height:34px;padding:0px">
                    {{Form::text('name',$role->name,array('class'=>'form-control','style'=>'background-color:rgb(241,241,241);border:0px solid rgb(241,241,241)'))}}
                </td>
                <td style="height:34px;padding:0px">
                    {{Form::text('description',$role->description,array('class'=>'form-control','style'=>'background-color:rgb(241,241,241);border:0px solid rgb(241,241,241)')) }}
                </td>
                {{Form::close()}}
                <td style="height:34px;padding:0px">
                    {{ Form::open(array('url'=>'role/showScopes','method'=>'GET')) }}
                    {{ Form::hidden('roleId', $role->id) }}
                    <button type="submit" class="btn btn-primary btn-sm">管理</button>
                    {{Form::close()}}
                </td>
                <td style="height:34px;padding:0px">
                    {{Form::button('删除',array('name'=>'roleDelBtn', 'class'=>'btn btn-danger btn-sm'))}}
                </td>

            </tr>
        @endforeach
    </table>
@stop
