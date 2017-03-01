@extends('layouts.test')

@section('content')
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            {{ $params }}
        </div>
        <div class="col-md-4"></div>
    </div>

@stop