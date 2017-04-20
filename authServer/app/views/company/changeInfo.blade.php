@extends('layouts.master')

@section('title')
    @parent
    :: 修改组织信息
@stop

{{-- Content --}}
@section('content')
    <div class="page-header">
        <h2>修改组织信息</h2>
    </div>

    {{ Form::open(array('url' => 'changeCompanyInfo', 'method' => 'post', 'class' => 'form-horizontal', 'role' => 'form')) }}
    <!-- 公司名称 -->
    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
        {{ Form::label('name', '组织名称', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-star fa-fw"></i></span>
                {{ Form::text('name', $name, array('class' => 'form-control')) }}
            </div>
        </div>
        <p class="col-sm-3 form-control-static text-danger">
            {{ $errors->first('name') }}
        </p>
    </div>

    <!-- 公司邮箱 -->
    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
        {{ Form::label('email', '组织邮箱', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
                {{ Form::text('email', $email, array('class' => 'form-control')) }}
            </div>
        </div>
        <p class="col-sm-3 form-control-static text-danger">
            {{ $errors->first('email') }}
        </p>
    </div>

    <!-- 公司地址 -->
    <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
        {{ Form::label('address', '组织地址', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-quote-left fa-fw"></i></span>
                {{ Form::text('address', $address, array('class' => 'form-control')) }}
            </div>
        </div>
        <p class="col-sm-3 form-control-static text-danger">
            {{ $errors->first('address') }}
        </p>
    </div>

    <!-- 联系方式 -->
    <div class="form-group" id="redirect_url">
        <label class="col-sm-2 control-label" for="redirect_url">联系方式</label>
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-shield fa-fw"></i></span>
                {{ Form::text('phone', $phone, array('class'=>'form-control')) }}
            </div>
        </div>
    </div>
	{{ Form::hidden('id', $companyId) }}
	{{ Form::hidden('old_name', $name) }}
	{{ Form::hidden('old_email', $email) }}
	{{ Form::hidden('old_address', $address) }}
	{{ Form::hidden('old_phone', $phone) }}
    <!-- 注册按钮 -->
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            {{ Form::submit('创建', array('class' => 'btn btn-success')) }}
        </div>
    </div>

    <!-- 测试用 -->
    <!--{{ Form::hidden('access_token', '11bBY7avOXmDMY3zygcYxUSrJdiAImhnPtgU3nVn') }}-->

    {{ Form::close() }}
    @stop
            <!-- 注册按钮 -->
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            {{ Form::submit('创建', array('class' => 'btn btn-success')) }}
        </div>
    </div>

    <!-- 测试用 -->
    <!--{{ Form::hidden('access_token', '11bBY7avOXmDMY3zygcYxUSrJdiAImhnPtgU3nVn') }}-->

    {{ Form::close() }}
@stop
