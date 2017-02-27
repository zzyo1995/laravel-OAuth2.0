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
        <tr>
            <th>{{ $userInfo['userId'] }}</th>
            <td>
                @if($userInfo['groupID'] == '0')
                    None
                @elseif($userInfo['groupID'] == '1')
                    Group-1
                @elseif($userInfo['groupID'] == '2')
                    Group-2
                @endif
            </td>
            <td>{{ $userInfo['username'] }}</td>
            <td>{{ $userInfo['email'] }}</td>
        </tr>
        </tbody>
    </table>
</div>
@stop