@extends('layouts.manage')

@section('title')
    人员管理 < @parent
@stop

{{-- Content --}}
@section('caption')
    可管理的组织
    @stop

@section('content')

<div>
<ul class="add_user_ul" >
    @foreach($companies as $company)
        <li style="border: 1px solid #000002">
            {{$company->name}}

            {{ Form::open(array('url' =>'manage/allUser/'.$company->id, 'role' => 'form','method' => 'get'))}}
            {{ Form::hidden('id', $company->id) }}
				<button type="submit" class="btn btn-primary" style="width: 70px">人员管理</button>
            {{ Form::close() }}

        </li>

    @endforeach
</ul>
{{--    <div align="right">
        <?php echo $companies->links();?>
    </div>--}}
</div>



@stop
