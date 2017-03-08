@extends('layouts.master')

@section('title')
    @parent :: 接口
@stop

@section('content')
    <div class="container">
        <div class="page-header">
            <h2>接口列表</h2>
        </div>
        <div class="row">
            <div class="col-md-2">
                <ul class="nav nav-pills nav-stacked">
                    @foreach($groupList as $group)
                        <li class="{{ $activeGroup == $group->id ? 'active' : '' }}">
                            <a href="/api-manage/?group_id={{ $group->id }}">{{ $group->name }}</a>
                        </li>
                    @endforeach
                    @if($admin)
                            <a href="addGroup" class="btn btn-success active" role="button" style="margin-top: 30px">添加接口组</a>
                    @endif
                </ul>
            </div>
            <div class="col-md-10">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>API名称</th>
                        <th>URL</th>
                        @if($admin)
                            <th>管理</th>
                        @else
                            <th>详情</th>
                        @endif
                        <th>测试</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($apiList as $api)
                        <tr>
                            <th>{{$api->name}}</th>
                            <td>{{$api->url}}</td>
                            <td>
                                @if($admin)
                                    <a href="api-manage/manage?api_id={{ $api->id }}" class="btn btn-primary active"
                                       role="button">管理</a>
                                @else
                                    <a href="api-manage/info?api_id={{ $api->id }}" class="btn btn-primary active"
                                       role="button">详情</a>
                                @endif
                            </td>
                            <td>
                                <a href="api-manage/test?api_id={{ $api->id }}" class="btn btn-primary active"
                                   role="button">测试</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if($admin)
                    <div align="right">
                        <a href="api-manage/addApi" class="btn btn-primary active" role="button">新建接口</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop


