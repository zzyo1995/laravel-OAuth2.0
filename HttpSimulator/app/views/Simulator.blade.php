<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Simulator</title>
    <!-- Bootstrap -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <style>
            body {
            padding-top: 60px;
        }
    </style>
</head>
<body style="padding-top: 30px">
    <div class="container">
        <form style="border: thin solid #5bc0de;padding:20px 30px;border-radius: 15px">
            <div class="row" id="params_start">
                <div class="col-md-2">
                    <select class="form-control" id="http_method">
                        <option value="POST">POST</option>
                        <option value="GET">GET</option>
                    </select>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="api_url" placeholder="http://">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-info" id="send" type="button">发送请求</button>
                </div>
            </div>
            <table id="params_table" class="table table-striped table-bordered" style="position: relative; top: 15px">
                <thead>
                <tr>
                    <th width="35%">Body参数名称</th>
                    <th>Body参数值</th>
                </tr>
                </thead>
                <tbody>
                <tr id="params_end">
                    <td colspan="2">
                        <button class="btn btn-info" id="add_url_parameter" type="button">添加参数</button>
                        {{--<button class="btn btn-info" id="add_raw_url_parameter" type="button">RAW批量添加</button>--}}
                    </td>
                </tr>
                </tbody>
            </table>
            <table id="headers_table" class="table table-striped table-bordered" style="position: relative; top: 15px">
                <thead>
                <tr>
                    <th width="35%">Header参数名称</th>
                    <th>Header参数值</th>
                </tr>
                </thead>
                <tbody>
                <tr id="headers_end">
                    <td colspan="2">
                        <button class="btn btn-info" id="add_api_headers" type="button">添加Header</button>
                    </td>
                </tr>
                </tbody>
            </table>
            <table id="response_table" class="table table-striped table-bordered" style="position: relative; top: 15px">
                <thead>
                <tr>
                    <th width="35%">Response Header</th>
                    <th>Response Body</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <textarea id="response_header" class="form-control" rows="10" readonly></textarea>
                    </td>
                    <td>
                        <textarea id="response_body" class="form-control" rows="10" readonly></textarea>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
        <script src="{{ asset('js/simulator.js') }}"></script>
    </div>
</body>
</html>