@extends('layouts.master')

@section('title')
@parent
:: Login
@stop

<?php
    session_start();
    if ( !isset($_SESSION['attempt_login_num']) ){
        $_SESSION['attempt_login_num'] = 0;
    }

?>
{{-- Content --}}
@section('content')
<div class="page-header">
    <h2>用户登录</h2>
</div>

{{ Form::open(array('url' => 'login', 'class' => 'form-horizontal', 'role' => 'form')) }}
    <!-- 邮箱 -->
    <div class="form-group {{{ $errors->has('email') ? 'has-error' : '' }}}">
        {{ Form::label('email', '电子邮件', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
                {{ Form::text('email', Input::old('email'),
                array('placeholder' => 'youremail@someprovider.com', 'class' => 'form-control')) }}
            </div>
        </div>
        <p class="col-sm-3 form-control-static text-danger">
            {{ $errors->first('email') }}
        </p>
    </div>

    <!-- 密码 -->
    <div class="form-group {{{ $errors->has('password') ? 'has-error' : '' }}}">
        {{ Form::label('password', '密码', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
                {{ Form::password('password', array('class' => 'form-control')) }}
            </div>
        </div>
        <p class="col-sm-3 form-control-static text-danger">
            {{ $errors->first('password') }}
        </p>
    </div>

    <?php

    if($_SESSION['attempt_login_num'] > 3 ) {?>

    {{--验证码--}}
    <div class="form-group">
        {{ Form::label('', '', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-3">
            <div class="input-group">
                <img src="vcode/code.php" onclick="this.src='vcode/code.php?'+Math.random()"/><small><small> 点击图片刷新</small></small>
            </div>
        </div>
    </div>
    {{--验证码输入表单--}}
    <div class="form-group {{{ $errors->has('vcode') ? 'has-error' : '' }}}">
        {{ Form::label('vcode', '验证码', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                {{ Form::text('vcode',Input::old('vcode'), array('placeholder' => 'CAPTCHA', 'class' => 'form-control')) }}
            </div>
        </div>
        <p class="col-sm-3 form-control-static text-danger">
            {{ $errors->first('vcode') }}
        </p>
    </div>
    <?php }
    ?>

    <!-- 登录按钮 -->
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            {{ Form::submit('登录', array('class' => 'btn btn-success')) }}
            {{ Form::button('忘记密码', [
                'class' => 'btn btn-warning',
                'onclick' => 'javascript:location.href="'.action('RemindersController@getRemind').'"'
            ]) }}
        </div>
    </div>
        
{{ Form::close() }}
@stop
