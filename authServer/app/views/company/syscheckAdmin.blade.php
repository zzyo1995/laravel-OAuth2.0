@extends('layouts.sysadmin')

@section('title')
审核组织管理员 < @parent
@stop

@section('content')

        <h2 align="center">组织管理员审核</h2>

      <div>
        <p style="margin-left: 8px;"><label>筛选条件：</label></p>
        <div style="margin-left: 8px;">
            审核状态:

                <select id="admin_apply_state_select" style="border:0px;" >
                    <option value="1">审核通过</option>
                    <option value="0">待审核</option>
                    <option value="2">审核不通过</option>
                </select>

        </div>
    </div>
        <div style="margin-bottom: 30px;"></div>
        <form action="applier" method="get" id="hiddenForm">
            <input type="hidden" name="state" id="admin_apply_state" value="<?php echo $state; ?>" />
            <input hidden type="submit"/>
        </form>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active">
            <table class="table" id="allAdminApplies">
                <thead>
                <tr>
                    <th>公司名称</th>
                    <th>申请人</th>
                    <th>申请人邮箱</th>
                    <th>申请原因</th>
                    @if($state == 0)
                    <th>操作</th>
                    <th></th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @if($applyInfo[0] != null)
                    @foreach ($applyInfo as $applier)
                        <tr id="{{$applier['applyId']}}">
                            <td>{{ $applier['companyName'] }}</td>
                            <td>{{ $applier['userName'] }}</td>
                            <td>{{ $applier['userEmail'] }}</td>
                            <td>{{ $applier['reason'] }}</td>
                            @if($applier['state'] == 0)
                                <td width="50px;">
                                    <input type="button" state="1" name="check_apply" value="同意" class="btn btn-danger btn-sm" />
                                </td>
                                <td width="50px">
                                    <input type="button" state="2" value="拒绝" name="check_apply" class="btn btn-danger btn-sm"/>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>

@stop
