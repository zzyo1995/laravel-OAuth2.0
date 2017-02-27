@extends('layouts.test')

@section('content')
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <button class="btn btn-default" type="button">
                <a href="/getUserInfo">
                    获取用户信息
                </a>
            </button>
            <button class="btn btn-default" type="button">
                <a href="/refreshAccessToken">
                    刷新AccessToken
                </a>
            </button>
        </div>
        <div class="col-md-4"></div>
    </div>

@stop