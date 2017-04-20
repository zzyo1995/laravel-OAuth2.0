@extends('layouts.master')

@section('title')
    @parent
    :: 企业通讯录
@stop

{{-- Content --}}
@section('content')

    <div class="page-header">
        <h2>企业通讯录</h2>
    	<span style="text-align: left">
    	{{ Form::open(['url' => 'user/getSearchUsers','class' => 'form-horizontal','role' => 'form', 'method' => 'get']) }}
		{{ Form::hidden('id', $id) }}
		{{ Form::hidden('export', "yes") }}
		{{ Form::hidden('dname', $dname) }}
		{{ Form::hidden('type', $type) }}
        {{ Form::submit('导出', ['id' => 'sub1','class' => 'btn btn-success']) }}	
    	{{ Form::close() }}
    	</span>
		<div style="text-align: center">
    	{{ Form::open(['url' => 'user/getSearchUsers','class' => 'form-horizontal','role' => 'form', 'method' => 'get']) }}
		{{ Form::text('name', Input::old('name'), ['class' => 'add_user_input']) }}
        {{ Form::submit('人员查找', ['id' => 'sub','class' => 'btn btn-success']) }}	
		{{ Form::hidden('id', $id) }}
		{{ Form::hidden('type', 1) }}
    	{{ Form::close() }}
		</div>
		<div style="text-align: center">
    	{{ Form::open(['url' => 'user/getSearchUsers','class' => 'form-horizontal','role' => 'form', 'method' => 'get']) }}
        {{ Form::text('name', Input::old('name'), ['class' => 'add_user_input']) }}
        {{ Form::submit('组织查找', ['id' => 'sub','class' => 'btn btn-danger']) }}	
		{{ Form::hidden('id', $id) }}
		{{ Form::hidden('type', 2) }}
    	{{ Form::close() }}
		</div>
    </div>
    @if($allUser !== -1 )
    <ul >
        @foreach($allUser as $user)
            <li style="display: inline-block;margin: 10px 10px  ">
                <table border="1" width="340" height="180" id="{{ $user->email }}">

                    <tr>

                        @if( $user->portrait != NULL)
                            <th rowspan="4" width="120" style="text-align: center"><img src="/img/{{ $user->portrait }}" width='100' height='100' ></th>
                        @else
                            <th rowspan="4" width="120" style="text-align: center"><img src="/image/default" width='100' height='100' ></th>
                        @endif
                        <td><span style="padding-left: px;">姓名：{{$user->username}}</span></td>
                    </tr>
                    <tr>
                        <td><span style="padding-left: 0px;">邮箱：{{$user->email}}</span></td>
                    </tr>
                    <tr>
                        <td><span style="padding-left: px;">电话：{{$user->phone}}</span></td>
                    </tr>
                    <tr>
                        <td><span style="padding-left: px;">分机号：{{$user->extension_number}}</span></td>
                    </tr>
					<tr>
                        <td><span style="padding-left: px;">类型：
							<?php echo DB::table('oauth_roles')->where('name', $user->user_category)->pluck('description');?>
						</span></td>
						<td><span style="padding-left: px;">部门：{{$user->group_name}}</span></td>

                    </tr>
                    <tr>
                        <td><span style="padding-left: px;">房间号：{{$user->room_number}}</span></td>
						<td><span style="padding-left: px;">备注：{{$user->remark}}</span></td>
                    </tr>
                </table>

            </li>

        @endforeach
    </ul>
    <div align="right">
        <?php
            echo $companyUsers->links();
        ?>
    </div>
	@endif
@stop
