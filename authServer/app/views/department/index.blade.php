@extends('layouts.manage')

@section('title')
    部门管理 < @parent
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

                    {{ Form::open(array('url' =>'manage/showGroups', 'role' => 'form','method' => 'GET'))}}
                    {{ Form::hidden('companyId', $company->id) }}
                    {{ Form::hidden('companyName', $company->name) }}
                    <button type="submit" class="btn btn-primary">组管理</button>
                    {{ Form::close() }}

                </li>

            @endforeach
        </ul>
        {{--    <div align="right">
                <?php echo $companies->links();?>
            </div>--}}
    </div>



@stop