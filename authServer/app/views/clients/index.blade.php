@extends('layouts.admin')

@section('title')
客户端管理 < @parent
@stop

{{-- Content --}}
@section('caption')
客户端列表
@stop
@section('content')
    <table class="table">
        <thead>
        <tr>
            <th>id</th>
            <th>名称</th>
            <th>secret</th>
            <th>scopes</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($clients as $client)
        <tr>
            <td>{{{ $client->id }}}</td>
            <td>{{{ $client->name }}}</td>
            <td>{{{ $client->secret }}}</td>
            <td>
                @foreach ($client->scopes as $scope)
                {{{ $scope['scope'] }}}
                @endforeach
            </td>
            <td>
                {{ Form::open(['url' => 'clients/'.$client->id, 'method' => 'delete']) }}
                <button type="submit" class="btn btn-danger btn-sm">删除</button>
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

</div>
@stop
