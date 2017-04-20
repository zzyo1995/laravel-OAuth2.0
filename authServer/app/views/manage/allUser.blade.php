@extends('layouts.manage')

@section('title')
    组织成员列表 < @parent
@stop

{{-- Content --}}
{{--@section('caption')
    组织成员列表
    @stop--}}

    @section('content')
        <h1 style="text-align: center;">
            {{ $company->name }}
        </h1>

	<div style="text-align: center">
		{{ Form::open(['url' => 'manage/companyUserSearch','class' => 'form-horizontal','role' => 'form', 'method' => 'get']) }}
		{{ Form::hidden('id', $company->id) }}
		
		{{ Form::text('name', Input::old('name'), ['class' => 'add_user_input']) }}
		{{ Form::submit('人员查找', ['id' => 'sub','class' => 'btn btn-success']) }}	
		
		{{ Form::close() }}
	</div>
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active">
            <table class="table" id="allCompanyTable">
                <thead>
                <tr>
                    <th>用户名</th>
                    <th>电子邮件</th>
                    <th>员工类型</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @if($users != null)
                    @foreach ($users as $user)
                        <tr id="$user->id">
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->category_description }}</td>
                            @if(Auth::user()->id != $user->id)
                                <td>
                                    {{--{{ Form::open(['url' => 'manage/deleteUser' , 'method' => 'POST']) }}--}}
                                    {{--{{ Form::hidden('user_id', $user->id) }}--}}
                                    {{--{{ Form::hidden('company_id', $company->id)}}--}}
                                    {{--{{ Form::button('删除', array('class'=>'btn btn-danger btn-sm', 'type'=>'submit'))}}--}}

                                    {{--{{ Form::close() }}--}}
                                    <input type="button" name="delbtn" userid="{{$user->id}}" companyid="{{$company->id}}" class="btn btn-danger btn-sm" value="删除" />
                                </td>
                            @endif
                    </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
@if($companyUsers != null)
    <div align="right">
        <?php
            echo $companyUsers->links();
        ?>
    </div>
@endif
@stop
