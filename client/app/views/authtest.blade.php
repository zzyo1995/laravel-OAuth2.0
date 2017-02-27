@extends('layouts.test')

@section('content')
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <button class="btn btn-default"
                    type="button">
                <a href="http://localhost:8000/auth/authorize?client_id=client1id&client_secret=client1secret&response_type=code&redirect_uri=http://localhost:8001/callback">
                    网络账号登录
                </a>
            </button>
        </div>
        <div class="col-md-4"></div>
    </div>

@stop