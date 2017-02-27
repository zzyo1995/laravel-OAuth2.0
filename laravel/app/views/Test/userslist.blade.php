@extends('layouts.test')

@section('content')
    <div class="container">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Group</th>
                <th>UserName</th>
                <th>Email</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <th>{{$user->id}}</th>
                    <td>
                        @if($user->group_id == '0')
                            None
                        @elseif($user->group_id == '1')
                            Group-1
                        @elseif($user->group_id == '2')
                            Group-2
                        @endif
                    </td>
                    <td>{{$user->username}}</td>
                    <td>{{$user->email}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop