@extends('layouts.sysadmin')

@section('title')
用户管理 < @parent
@stop

{{-- Content --}}
@section('caption')
用户列表 
@stop

@section('content')
<!-- Nav tabs -->
<ul class="nav nav-tabs">
    	<li class="active"><a href="#allusers" data-toggle="tab">所有用户</a></li>
	    <li><a href="#clientActiveusers" data-toggle="tab">客户端在线用户</a></li>
    	<li><a href="#activeusers" data-toggle="tab">web在线用户</a></li>

</ul>

<!-- Tab panes -->
<div class="tab-content">
	<div class="tab-pane" id="clientActiveusers">
 		<table class="table table-striped">
            <thead>
            <tr>
                <th>用户名</th>
                <th>电子邮件</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($clientActiveUsers as $user)
            <tr>
                <td>{{{ $user->username }}}</td>
                <td>{{{ $user->email }}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
	</div>
    <div class="tab-pane" id="activeusers">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>用户名</th>
                <th>电子邮件</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($active as $user)
            <tr>
                <td>{{{ $user->username }}}</td>
                <td>{{{ $user->email }}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="tab-pane active" id="allusers">
        <table class="table">
            <thead>
            <tr>
                <th>用户名</th>
                <th>电子邮件</th>
				<th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($all as $user)
            <tr>
                <td>{{{ $user->username }}}</td>
                <td>{{{ $user->email }}}</td>
				<td>
					{{ Form::open(['url' => 'users/'.$user->id, 'method' => 'delete']) }}
	                		<button type="submit" class="btn btn-danger btn-sm">删除</button>
		            		{{ Form::close() }}
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop
