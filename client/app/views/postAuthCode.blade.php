@extends('layouts.test')

@section('content')
<form id="authCodePost" name="authCodePost" action="http://localhost:8000/auth/access_token" method="post">
    <input type="hidden" name="grant_type" value={{ $params['grant_type'] }}>
    <input type="hidden" name="client_id" value={{ $params['client_id'] }}>
    <input type="hidden" name="client_secret" value={{ $params['client_secret'] }}>
    <input type="hidden" name="redirect_uri" value={{ $params['redirect_uri'] }}>
    <input type="hidden" name="code" value={{ $params['code'] }}>
    <input type="submit" style="display: none">
    <script>document.forms['authCodePost'].submit();</script>
</form>
@stop