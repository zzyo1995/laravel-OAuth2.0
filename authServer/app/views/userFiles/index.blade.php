@extends('layouts.admin')

@section('title')
用户文件资源列表
@stop

@section('content')
	<h2>用户文件资源列表</h2>
	<hr />
	<table class="table" style="margin:0px;padding: 0px">
		<thead>
			<tr>
				<td style="padding:0px;margin:0px">文件名</td>
				<td style="padding:0px;margin:0px">文件大小</td>
				<td style="padding:0px;margin:0px">文件类型</td>
				<td style="padding:0px;margin:0px">删除</td>
			</tr>
		</thead>
		<tbody>
			@foreach ($userFiles as $eachFile)
				<tr>
					<td style="padding:0px;margin:0px">{{ $eachFile['filename'] }}</td>
					<td style="padding:0px;margin:0px">{{ $eachFile['filesize'] }}</td>
					<td style="padding:0px;margin:0px">{{ $eachFile['filetype'] }}</td>
					<td style="padding:0px;margin:0px">
						{{ Form::open(array('url'=>'test','method'=>'post','class'=>'form','role'=>'form','style'=>'padding:0px;margin:0px')) }}
							{{ Form::submit('删除',array('class'=>'btn btn-danger btn-sm')) }}
						{{ Form::close() }}
					</td>
				</tr>
			@endforeach			
		</tbody>
	</table>
	<div class="row" style="padding:0px;margin:0px">
		<div class="col-md-5 offset4">
			{{ $filePaginates->links() }} 
		</div>
	{{ Form::open(array('url'=>'','class'=>'form col-md-2','style'=>'padding:0px;margin-top:30px','id'=>'pageNum')) }}
		<div class="form-group">
			<label class="control-label">选择每页显示数目：</label>
			{{Form::select('pageNum',array('5'=>'5','10'=>'10','15'=>'15'),array('selected'=>Session::has('pageNum')?Session::get('pageNum'):'5'))}}
		</div>
	{{Form::close()}}
	</div>
@stop