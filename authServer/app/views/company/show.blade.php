@extends('layouts.master')

@section('title')
    @parent
    :: 我的组织
@stop

{{-- Content --}}
@section('content')

<div class="page-header">
    <h2>我的组织</h2>
</div>


    <ul>
        @if( $myJoin[0] !=null  )

        @foreach($myJoin as $eachJoin)
        <li style="display: inline-block;margin: 10px 20px  ">
            <table border="1" width="350" height="160">

                <tr>
                    <td><span style="padding-left: 5px;">名称：{{$eachJoin->name}}</span></td>
                    <td rowspan="4" style="text-align: center">

                        {{ Form::open(['url' => 'companyUser' ,'class' => 'form-horizontal','role' => 'form', 'method' => 'get']) }}
                            {{ Form::hidden('id', $eachJoin->id) }}
                            {{ Form::submit('管理', ['class' => 'btn btn-primary', 'style' => 'margin:10px 0px ']) }}
                        {{ Form::close() }}

                        {{ Form::open(['url' => 'companyUser/' . $eachJoin->id ,'class' => 'form-horizontal','role' => 'form', 'method' => 'get']) }}
{{--                            {{ Form::hidden('id', $eachJoin->id) }}--}}
                            {{ Form::submit('通讯录', ['class' => 'btn btn-success']) }}
                        {{ Form::close() }}

                        {{ Form::open(['url' => 'companyUser/' . $eachJoin->id,'class' => 'form-horizontal','role' => 'form', 'method' => 'delete']) }}
{{--                            {{ Form::hidden('id', $eachJoin->id) }}--}}
                            {{ Form::submit('退出', ['class' => 'btn btn-danger', 'style' => 'margin:10px 0px ']) }}
                        {{ Form::close() }}

                    </td>
                </tr>
                <tr>
                    <td><span style="padding-left: 5px;">邮箱：{{$eachJoin->email}}</span></td>
                </tr>
                <tr>
                    <td><span style="padding-left: 5px;">电话：{{$eachJoin->phone}}</span></td>
                </tr>
                <tr>
                    <td><span style="padding-left: 5px;">地址：{{$eachJoin->address}}</span></td>
                </tr>

            </table>

        </li>

        @endforeach
        @else
            <p>未加入任何组织</p>
        @endif

    </ul>

@stop