@extends('layouts.test')

@section('content')
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            {{ Form::open(array(
             'url' => 'login',
             'method'=>'post',
             'class' => 'form-horizontal'
             )) }}
            <div class="form-group">
                {{ Form::label('email','', 'Email') }}
                {{ Form::email('email','',array('class'=>'form-control', 'id'=>'email', 'placeholder'=>'Email') ) }}
            </div>
            <div class="form-group">
                {{ Form::label('password','', 'Password') }}
                {{ Form::password('password',array('class'=>'form-control', 'id'=>'password', 'placeholder'=>'Password')) }}
            </div>
            {{ Form::submit('授权',array('class'=>'btn btn-default')) }}
            {{ Form::close() }}
        </div>
        <div class="col-md-4"></div>
    </div>

@stop