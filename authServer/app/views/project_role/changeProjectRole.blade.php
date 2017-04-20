@extends('layouts.admin')

@section('title')
    修改角色信息
@stop

@section('caption')
    修改角色信息
@stop

@section('content')
    {{ Form::open(array('url'=>'project_role/changeInfo/'.$roleInfo->id, 'class' => 'form-horizontal', 'role' => 'form', 'method'=>'POST')) }}
    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
        {{ Form::label('name', '名称', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-quote-left fa-fw"></i></span>
                {{Form::text('name',$roleInfo->name,array('id'=>'name','placeholder'=>'名称','class'=>'form-control'))}}
            </div>
        </div>
        <p class="col-sm-3 form-control-static text-danger">
            {{ $errors->first('name') }}
        </p>
    </div>
    <div class="form-group {{ $errors->has('enname') ? 'has-error' : '' }}">
        {{ Form::label('enname', '值', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-quote-left fa-fw"></i></span>
                {{Form::text('value',$roleInfo->value,array('id'=>'value','placeholder'=>'值','class'=>'form-control'))}}
            </div>
        </div>
        <p class="col-sm-3 form-control-static text-danger">
            {{ $errors->first('enname') }}
        </p>
    </div>
    {{ Form::hidden('old_name', $roleInfo->name) }}
    {{ Form::hidden('old_value', $roleInfo->value) }}
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">{{ Form::submit('新建',array('class' => 'btn btn-success')) }}</div>
    </div>
    {{Form::close()}}
@stop
