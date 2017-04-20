@extends('layouts.master')

@section('title')
@parent
:: 组织管理
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
    <h2>组织管理</h2>
</div>
<div style="text-align: center">
    {{ Form::open(['url' => 'company/getEnabled','class' => 'form-horizontal','role' => 'form', 'method' => 'get']) }}

		{{ Form::text('name', Input::old('name'), ['class' => 'add_user_input']) }}
        {{ Form::submit('查找', ['id' => 'sub','class' => 'btn btn-success', 'disabled']) }}	

    {{ Form::close() }}
</div>
<div class="container" align="left">
	{{ Form::open(['url' => 'company/create', 'method' => 'get']) }}
		<button type="submit" class="btn btn-primary btn-sm">创建组织</button>
	{{Form::close() }}
</div>
<table class="table">
        <thead>
        <tr>
            <th>名称</th>
            <th>email</th>
            <th>修改</th>
            <th>删除</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($companies as $company)
        <tr>
            <td>{{{ $company->name }}}</td>
            <td>{{{ $company->email }}}</td>
            <td>
            	{{ Form::open(array('url' => 'changeCompanyInfo', 'method' => 'get')) }}
                {{ Form::hidden('id', $company->id) }}
                {{ Form::hidden('name', $company->name) }}
                {{ Form::hidden('email', $company->email) }}
                {{ Form::hidden('address', $company->address) }}
                {{ Form::hidden('phone', $company->phone) }}
                <button type="submit" class="btn btn-primary btn-sm">修改</button>
                {{Form::close() }}
            </td>
            <td>
                {{ Form::open(['url' => 'company/delete/'.$company->id, 'method' => 'get']) }}
                <button type="submit" onClick="return confirm('确认要删除？')" class="btn btn-danger btn-sm">删除</button>
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
        </tbody>
</table>

</div>
<div align="right">
	<?php echo $companies->links();?>
</div>
@stop
