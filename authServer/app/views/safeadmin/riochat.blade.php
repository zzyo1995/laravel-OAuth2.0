@extends('layouts.safeadmin')

@section('title')
    riochat < @parent
@stop

{{-- Content --}}
@section('caption')
    riochat
@stop
@section('content')
    <div class="container">
        {{ Form::open(array('url' => 'safeadmin/add_juris_user/riochat','method' => 'post')) }} {{
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
            <th>用户密级</th>
            <th>修改</th>
            <th>移除</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($clients as $client)
            <tr>
                {{ Form::open(array('url' => 'safeadmin/change_juris/'.$client->id.'/riochat', 'method' => 'post')) }}
                <td>{{{ $client->username }}}</td>
                <td>{{{ $client->email }}}</td>
                <td>
                    <select name="user_miji">
                        @if($client->user_miji == "1")
                            <option selected= "selected" value="1">普通用户</option>
                        @else
                            <option value="1">普通用户</option>
                        @endif
                        @if($client->user_miji == "2")
                            <option selected= "selected" value="2">管理员</option>
                        @else
                            <option value="2">管理员</option>
                        @endif
                    </select>
                </td>
                <td>
                    <button type="submit" class="btn btn-primary btn-sm">修改</button>
                </td>
                {{ Form::close() }}
                <td>
                    {{ Form::open(array('url' =>
                    'safeadmin/remove_juris_user/'.$client->id.'/riochat','method' => 'post'))
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
