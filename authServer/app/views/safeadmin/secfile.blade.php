@extends('layouts.safeadmin')

@section('title')
    secfile < @parent
@stop

{{-- Content --}}
@section('caption')
    secfile
@stop
@section('content')

    <div class="container">
        {{ Form::open(array('url' => 'safeadmin/add_juris_user/secfile','method' => 'post')) }} {{
	    Form::label('name', '添加到修改列表', array('class' => 'control-label')) }}
        <select name="user_id"  style="width:90px;">
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
    <div class="container_table">
    <table class="table">
        <thead>
        <tr>
            <th>用户名称</th>
            <th>邮箱</th>
            <th>密级</th>
            <th>用户状态</th>
            <th>添加管理员</th>
            <th>修改</th>
            <th>移除</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($clients as $client)
            <tr>
                {{ Form::open(array('url' => 'safeadmin/change_juris/'.$client->id.'/secfile', 'method' => 'post')) }}
                <td>{{{ $client->username }}}</td>
                <td>{{{ $client->email }}}</td>
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
                    <select name="userstatus">
                        @if($client->userstatus == "active")
                            <option selected= "selected" value="active">活跃</option>
                        @else
                            <option value="active">活跃</option>
                        @endif
                        @if($client->userstatus == "inactive")
                            <option selected= "selected" value="inactive">不活跃</option>
                        @else
                            <option value="inactive">不活跃</option>
                        @endif
                    </select>
                </td>
                <td>
                    <select name="addadmin">
                        @if($client->addadmin == "0")
                            <option selected= "selected" value="0">移除管理员</option>
                        @else
                            <option value="0">移除管理员</option>
                        @endif
                        @if($client->addadmin == "1")
                            <option selected= "selected" value="1">添加管理员</option>
                        @else
                            <option value="1">添加管理员</option>
                        @endif
                    </select>
                </td>
                <td>
                    <button type="submit" class="btn btn-primary btn-sm">修改</button>
                </td>
                {{ Form::close() }}
                <td>
                    {{ Form::open(array('url' =>
                    'safeadmin/remove_juris_user/'.$client->id.'/secfile','method' => 'post'))
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
