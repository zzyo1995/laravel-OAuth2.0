@extends('layouts.test')

@section('content')
    {{--    <div>
        {{ Form::open(array('url' => 'register')) }}
        {{ Form::label('username', 'UserName') }}
        {{ Form::text('username') }}<br/>
        {{ Form::label('email', 'Email') }}
        {{ Form::text('email') }}<br/>
        {{ Form::label('password', 'Password') }}
        {{ Form::password('password') }}<br/>
        {{ Form::submit('Sign up') }}
        {{ Form::close() }}
        </div>--}}

    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            {{ Form::open(array('url' => 'register', 'method'=>'post', 'class' => 'form-horizontal')) }}
            {{--{{ csrf_field() }}--}}
            <div class="form-group">
                {{ Form::label('group_id','', 'Group') }}
                {{ Form::select('group_id', array('0'=>'None', '1'=>'Group-1','2'=>'Group-2'), '0', array('class'=>'form-control'))}}
            </div>
            <div class="form-group">
                {{ Form::label('username','', 'UserName') }}
                {{ Form::text('username','',array('class'=>'form-control', 'id'=>'username', 'placeholder'=>'UserName') ) }}
            </div>
            <div class="form-group">
                {{ Form::label('email','', 'Email') }}
                {{ Form::email('email','',array('class'=>'form-control', 'id'=>'email', 'placeholder'=>'Email') ) }}
            </div>
            <div class="form-group">
                {{ Form::label('password','', 'Password') }}
                {{ Form::password('password',array('class'=>'form-control', 'id'=>'password', 'placeholder'=>'Password')) }}
            </div>
            {{ Form::submit('Sign up',array('class'=>'btn btn-default')) }}
            {{ Form::close() }}
        </div>
        <div class="col-md-4"></div>
    </div>

@stop