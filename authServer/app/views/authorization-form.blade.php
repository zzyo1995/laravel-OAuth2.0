@extends('layouts.auth')

@section('title')
@parent
:: 授权
@stop
<?php Session::put('switch_client_id', $params["client_id"]); Session::put('switch_redirect_uri', $params["redirect_uri"]); Session::put('switch_state', $params["state"]);?>
{{-- Content --}}
@section('content')
{{ Form::open(array('url' => 'oauth/authorize?client_id='.$params["client_id"].'&redirect_uri='.$params['redirect_uri'].'&response_type=code'.'&state='.$params['state'],
'method' => 'post', 'class' => 'form-horizontal', 'role' => 'form','style'=>'padding:40px;background-color:rgb(255,255,255);height:200px')) }}
        <label class="control-label col-md-5" for="authorize">当前用户</label>
        <label class="control-label" for="authorize">{{Auth::user()->email}}</label>
        <div class="control-group">
                <label class="control-label col-md-5" for="authorize">用户授权</label>
                <div class="col-md-7">
                        {{ Form::radio('authorize','deny',array('class'=>'form-control')) }}否
                        {{ Form::radio('authorize','approve',array('class'=>'form-control','style'=>'margin-left:30px')) }}是
                </div>
        </div>
        <div class="control-group pull-right col-md-6" style="margin-top: 30px">
            {{ Form::submit('授权', array('class' => 'btn btn-success')) }}
            {{ Form::reset('取消', [
                'class' => 'btn btn-warning',
                'onclick' => 'javascript:location.href="'.action('home').'"'
            ]) }}
            {{ Form::reset('切换用户', [
                'class' => 'btn btn-success',
                'onclick' => 'javascript:location.href="'.action('switchUser').'"'
            ]) }}
            {{ Form::close() }}
    </div>
@stop

