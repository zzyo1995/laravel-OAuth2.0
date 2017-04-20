@extends('layouts.master')

@section('title')
@parent
:: 用户信息
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
    <h2>{{{ $user->username }}}
        @if(!is_null($user->portrait))<img style="width:50px;height:50px;"src="/img/{{ $user->portrait }}">@endif
    </h2>
</div>
{{ Form::open(array('url' => '#', 'method' => 'put', 'class' => 'form-horizontal', 'role' => 'form')) }}

    <!-- 邮箱 -->
    <div class="form-group">
        {{ Form::label('email', '电子邮件', array('class' => 'col-sm-2 control-label')) }}
        <p class="col-sm-3 form-control-static">
            {{ $user->email }}
        </p>
    </div>

    <!-- 昵称 -->
    <div class="form-group {{{ $errors->has('username') ? 'error' : '' }}}">
        {{ Form::label('username', '昵称', array('class' => 'col-sm-2 control-label')) }}
        <p class="col-sm-3 form-control-static">
            {{ $user->username }}
        </p>
    </div>

    <!-- 编辑按钮 -->
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-1">
            {{ Form::button('更新信息', [
                'class' => 'btn btn-success',
                'onclick' => 'javascript:location.href="'.URL::secure('/users/'.$user->id.'/edit').'"'
            ]) }}
        </div>
        <div class="col-sm-1">
            {{ Form::button('修改密码', [
                'class' => 'btn btn-info',
                'onclick' => 'javascript:location.href="'.URL::secure('/users/'.$user->id.'/new-password').'"'
            ]) }}
        </div>
    </div>
{{ Form::close() }}
<div>
	<table class="table">
		<thead>
		<tr>
			<th>id</th>
			<th>access_token</th>
			<th>refresh_token</th>
			<th>有效期至</th>
			<th></th>
		</tr>
		</thead>
		<tbody>
		@foreach ($sessions as $session)
		<tr>
			<td>{{ $session->id }}</td>
			<td>{{ $session->access_token }}</td>
			<td>{{ $session->refresh_token }}</td>
			<td>{{ date("Y-m-d h:i:s", $session->access_token_expires) }}</td>
			<td>
				{{ Form::open(['url' => 'users/'.$user->id.'/revoke_token', 'method' => 'post']) }}
				{{ Form::hidden('session_id', $session->id) }} <!-- TODO: provide real parameters for revoke_token -->
				<button type="submit" class="btn btn-danger btn-sm">撤销</button>
				{{ Form::close() }}
			</td>
		</tr>
		@endforeach
	</table>

</div>
@stop
