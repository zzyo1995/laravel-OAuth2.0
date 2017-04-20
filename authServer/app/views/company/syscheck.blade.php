@extends('layouts.sysadmin')

@section('title')
    组织结构管理
@stop

@section('content')
    <h2 align="center">组织审核</h2>
    <hr />
    <div id="all">
        <table id="allCompanyTable" class="table">
            <thead>
            <tr>
                <th>组织名</th>
                <th>审核状态</th>
                <th>修改</th>
                <th>组织注册时间</th>
                <th>备注</th>
{{--                <th>删除</th>--}}
            </tr>
            </thead>
            <tbody>
            @foreach ($allCompany as $eachCompany)
                <tr>
                    <td>{{$eachCompany->name}}</td>
                    @if ($eachCompany->state == 0)
                        <td>{{ "未审批" }}</td>
                    @elseif ($eachCompany->state == 1)
                        <td>{{ "审批成功" }}</td>
                    @else
                        <td>{{ "审批失败" }}</td>
                    @endif

                    <td>{{Form::button('修改',array('class'=>'btn btn-parmary','data-toggle'=>'modal','data-target'=>'#companyModal'))}}</td>
                    <td>{{$eachCompany->created_at}}</td>
                    <td>{{$eachCompany->reason}}</td>
{{--                    <td>删除</td>--}}
                </tr>
            @endforeach
            </tbody>
        </table>
        <div align="right">
            <?php echo $allCompany->links();?>
        </div>
    </div>



    <!-- 模态对话框 -->

    <!-- Modal -->
    <div class="modal fade" id="companyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">组织信息修改</h4>
                </div>
                <div class="modal-body">
                    {{Form::open(array('url'=>'testAjax','class'=>'form-horizontal','role'=>'form','id'=>'companyForm'))}}
                            <!-- resource server name -->
                    <div class="form-group">
                        <label class="control-label col-md-4" for="name">组织名称</label>
                        <div class="col-md-6">
                            {{ Form::text('name','',array('class'=>'form-control','readonly'=>'true')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="state">审核状态</label>
                        <div class="col-md-6">
                            {{ Form::select('state',array('success'=>'审批成功','fail'=>'审批失败','undo'=>'未审批'),array('class'=>'form-control')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="created_at">组织注册时间</label>
                        <div class="col-md-6">
                            {{ Form::text('created_at','123',array('class'=>'form-control','readonly'=>'true')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="reason">组织备注</label>
                        <div class="col-md-6">
                            {{ Form::textarea('reason','',array('class'=>'form-control','placeholder'=>'备注信息')) }}
                        </div>
                    </div>
                    {{Form::close()}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" id="checkBtn" class="btn btn-primary">保存修改</button>
                </div>
            </div>
        </div>
    </div>

@stop
