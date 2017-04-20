@extends('layouts.auth')

@section('title')
@parent
::授权登陆
@stop

{{-- Content --}}
@section('content')
{{Form::open(array('url'=>'login','class'=>'form-horizontal','role'=>'form','style'=>'padding:40px;background-color:rgb(255,255,255);height:200px'))}}
    <div class="form-group {{{ $errors->has('email') ? 'has-error' : '' }}}">
        {{ Form::label('email', '电子邮件', array('class' => 'col-sm-4 control-label')) }}
        <div class="col-sm-6">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
                {{ Form::text('email', Input::old('email'),
                array('placeholder' => 'youremail@someprovider.com', 'class' => 'form-control')) }}
            </div>
        </div>
        <p class="col-sm-2 form-control-static text-danger">
            {{ $errors->first('email') }}
        </p>
    </div>
    {{ Form::hidden('action','netAuth') }}
    <div class="form-group {{{ $errors->has('password') ? 'has-error' : '' }}}">
        {{ Form::label('password', '密码', array('class' => 'col-sm-4 control-label')) }}
        <div class="col-sm-6">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
                {{ Form::password('password', array('class' => 'form-control')) }}
            </div>
        </div>
        <p class="col-sm-2 form-control-static text-danger">
            {{ $errors->first('password') }}
        </p>
    </div>

    <div class="form-group">
        <div class="pull-right col-sm-4">
            {{ Form::submit('登录', array('class' => 'btn btn-success')) }}
            {{ Form::button('忘记密码', [
                'class' => 'btn btn-warning',
                'onclick' => 'javascript:location.href="'.action('RemindersController@getRemind').'"'
            ]) }}
        </div>
    </div>
{{ Form::close() }}
@stop
