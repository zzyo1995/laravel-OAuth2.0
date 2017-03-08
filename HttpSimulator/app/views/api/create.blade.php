@extends('layouts.master')

@section('content')
    <div class="page-header">
        @if ($action == "create")
            <h2>新建接口</h2>
        @elseif ($action == "info")
            <h2>接口详情</h2>
        @elseif ($action == "manage")
            <h2>管理接口</h2>
        @elseif ($action == "test")
            <h2>接口测试</h2>
        @endif
    </div>
    <form style="border: thin solid #5bc0de;padding:20px 30px;border-radius: 15px">
        @unless($action == "create")
            <input type="hidden" class="form-control" id="api_id" hidden value={{$apiInfo->id}}>
        @endunless
        <div class="form-group">
            <label class="col-sm-2 control-label">接口分组: </label>
            <div class="col-sm-10">
                <select class="form-control" id="group_id">
                    @foreach($groupList as $group)
                        <option value="{{ $group->id }}" {{--selected="{{ exit($apiInfo)&&$apiInfo->group_id==$group->id ? 'selected':'' }}"--}}>{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">接口名称: </label>
            <div class="col-sm-10">
                @if ($action == "create")
                    <input type="text" class="form-control" id="api_name">
                @else
                    <input type="text" class="form-control" id="api_name" value={{$apiInfo->name}}>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">URL: </label>
            <div class="col-sm-10">
                @if ($action == "create")
                    <input type="text" class="form-control" id="api_url" placeholder="https://">
                @else
                    <input type="text" class="form-control" id="api_url" value={{$apiInfo->url}}>
                @endif

            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">请求方法: </label>
            <div class="col-sm-10">
                <select class="form-control" id="http_method">
                    @if($action == "create" || $apiInfo->method == "POST")
                        <option value="POST">POST</option>
                        <option value="GET">GET</option>
                    @else
                        <option value="GET">GET</option>
                        <option value="POST">POST</option>
                    @endif
                </select>
            </div>
        </div>
        <table id="params_table" class="table table-striped table-bordered" style="position: relative; top: 15px">
            <thead>
            <tr>
                <th width="50%">Body参数名称</th>
                @if($action == "test")
                    <th>Body参数值</th>
                @else
                    <th>Body参数介绍</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @unless ($action == "create")
                <?php $apiIndex = 0; ?>
                @foreach( $apiInfo->params as $key=>$value )

                    <tr class="params_p" cnt={{$apiIndex}}>
                        <td>
                            <input class="form-control" type="text" name="p_name_{{$apiIndex}}" value={{$key}} />
                        </td>
                        <td>
                            @if($action == "test")
                                <div class="col-md-12"><input class="form-control" type="text"
                                                              name="p_value_{{$apiIndex}}" placeholder={{$value}} />
                                </div>
                            @else
                                <div>
                                    <div class="col-md-10"><input class="form-control" type="text"
                                                                  name="p_value_{{$apiIndex}}" value={{$value}} />
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-warning" onclick="del_param(this);" type="button">
                                            删除
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                    <?php $apiIndex++;?>
                @endforeach
            @endunless
            @if ($action == "create" || $action == "manage")
                <tr id="params_end">
                    <td colspan="2">
                        <button class="btn btn-primary" id="add_url_parameter" type="button">添加参数</button>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>

        @if($action == "test")
            <div style="text-align:center">
                <button class="btn btn-success" id="sendApi" type="button">发送</button>
            </div>
        @endif

        <table id="response_table" class="table table-striped table-bordered" style="position: relative; top: 15px">
            <thead>
            <tr>
                @if($action == "test")
                    <th>返回值</th>
                @else
                    <th>成功返回值</th>
                    <th>失败返回值</th>
                @endif
            </tr>
            </thead>
            <tbody>
            <tr>
                @if($action == "test")
                    <td>
                        <textarea id="response_success" class="form-control" rows="10"></textarea>
                    </td>
                @else
                    <td>
                        @if($action == "info" || $action == "manage")
                            <textarea id="response_success" class="form-control"
                                      rows="10">{{$apiInfo->succ_res}}</textarea>
                        @else
                            <textarea id="response_success" class="form-control" rows="10"></textarea>
                        @endif
                    </td>
                    <td>
                        @if($action == "info" || $action == "manage")
                            <textarea id="response_failed" class="form-control"
                                      rows="10">{{$apiInfo->fail_res}}</textarea>
                        @else
                            <textarea id="response_failed" class="form-control" rows="10"></textarea>
                        @endif

                    </td>
                @endif
            </tr>
            </tbody>
        </table>
        <div style="text-align:center">
            @if ($action == "create")
                <button class="btn btn-success" id="saveApi" type="button">保存</button>
            @elseif ($action == "info")
                <input type="button" class="btn btn-primary" name="Submit" onclick="javascript:history.back(-1);"
                       value="返回上一页">
            @elseif ($action == "manage")
                <button class="btn btn-danger" id="deleteApi" type="button">删除</button>
                <button class="btn btn-success" id="updateApi" type="button">更新</button>
            @endif
        </div>
    </form>
@stop