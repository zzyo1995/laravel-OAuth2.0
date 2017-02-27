@extends('layouts.test')

@section('content')
<div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            {{ Form::open(array(
             'url' => 'auth/authorize?client_id='.$params["client_id"].'&redirect_uri='.$params['redirect_uri'].'&response_type=code',
             'method'=>'post',
             'class' => 'form-horizontal'
             )) }}
            <label class="control-label">{{Auth::user()->email}}</label>
            {{ Form::submit('授权',array('class'=>'btn btn-default')) }}
            {{ Form::close() }}
        </div>
        <div class="col-md-4"></div>
    </div>
@stop