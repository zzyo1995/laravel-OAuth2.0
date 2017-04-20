@extends('layouts.master')

@section('title')
    @parent
    :: 申请管理组织
@stop

{{-- Content --}}
@section('content')

<div class="page-header">
    <h2>申请管理组织</h2>
</div>

    {{ Form::open(array('url' => 'companyUser/postApplyAdmin', 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form')) }}
    <!-- 公司名称 -->
    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
        {{ Form::label('reason', '申请理由:', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-3">
            <div class="input-group">
                {{--<span class="input-group-addon"><i class="fa fa-star fa-fw"></i></span>--}}
                {{ Form::textarea('reason', Input::old('reason'), array('class' => 'form-control', 'style'=>'width:300px;height:200px;max-width:300px;max-height:200px')) }}
            </div>
        </div>
        <p class="col-sm-3 form-control-static text-danger">
            {{ $errors->first('reason') }}
        </p>

    </div>

        {{ Form::hidden('company_id', $company_id) }}
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            {{ Form::submit('申请', array('class' => 'btn btn-success')) }}
        </div>
    </div>

	{{ Form::close() }}





@stop
