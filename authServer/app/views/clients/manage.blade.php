@extends('layouts.master')

@section('title')
@parent
:: 客户端列表
@stop

{{-- Content --}}
@section('content')
	<div class="page-header">
		<h2>客户端管理</h2>
		<div class="container" align="left">
        	{{ Form::open(array('url' =>'client-register', 'method' => 'GET')) }}
        	<button type="submit" class="btn btn-primary btn-sm">注册客户端</button>
        	{{ Form::close() }}
    	</div>
	</div>

    <table class="table">
        <thead>
        <tr>
            <th>id</th>
            <th>名称</th>
            <th>secret</th>
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
                {{ Form::open(['url' => 'clients/'.$client->id, 'method' => 'delete']) }}
                <button type="submit" onClick="return confirm('确认要删除？')" class="btn btn-danger btn-sm">删除</button>
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

</div>
@stop
