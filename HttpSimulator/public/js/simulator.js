/**
 * Created by zzyo on 2017/3/1.
 */
/* js for front page start */
var raw_param_flag = 1;

function del_param(obj) {
    $(obj).parent().parent().parent().parent().remove();
    raw_param_flag++;
}

function del_raw_param(obj) {
    $(obj).parent().parent().remove();
    raw_param_flag = 1;
}

function add_parameter(cnt, name, value) {
    if (name == 'undefined' || name == null) {
        name = ''
    }
    if (value == 'undefined' || value == null) {
        value = ''
    }
    $('#params_end').before('<tr class="params_p" cnt="' + cnt + '">' +
        '<td>' +
        '<input class="form-control" type="text" name="p_name_' + cnt + '"  value="' + name + '"placeholder="Body参数名称"/>' +
        '</td>' +
        '<td>' +
        '<div class="row">' +
        '<div class="col-md-8"> <input class="form-control" type="text" name="p_value_' + cnt + '" value="' + value + '" placeholder="Body参数数值"/></div>' +
        '<div class="col-md-4"><button class="btn btn-warning" onclick="del_param(this);" type="button">删除参数</button></div>' +
        '</div>' +
        '</td>' +
        '</tr>');
}

function add_header(cnt, name, value) {
    if (name == 'undefined' || name == null) {
        name = ''
    }
    if (value == 'undefined' || value == null) {
        value = ''
    }
    $('#headers_end').before('<tr class="headers_p" cnt="' + cnt + '">' +
        '<td>' +
        '<input class="form-control" type="text" name="h_name_' + cnt + '"  value="' + name + '"placeholder="Header参数名称"/>' +
        '</td>' +
        '<td>' +
        '<div class="row">' +
        '<div class="col-md-8"> <input class="form-control" type="text" name="h_value_' + cnt + '" value="' + value + '" placeholder="Header参数数值"/></div>' +
        '<div class="col-md-4"><button class="btn btn-warning" onclick="del_param(this);" type="button">删除参数</button></div>' +
        '</div>' +
        '</td>' +
        '</tr>');
}

var param_cnt = 0;
$("#add_url_parameter").click(function () {
    param_cnt++;
    add_parameter(param_cnt, '', '');
    raw_param_flag--;
});

$("#add_raw_url_parameter").click(function () {
    if (raw_param_flag) {
        $('#params_end').before('<tr>' +
            '<td colspan="2">' +
            '<textarea class="form-control" rows="5" placeholder="输入如a=1&b=2&c=3（不要问号），或者{\'a\':1,\'b\':2}"></textarea>' +
            '<button class="btn btn-warning" type="button" onclick="del_raw_param(this)">删除Raw参数</button>' +
            '</td>' +
            '</tr>');
        raw_param_flag = 0;
    }
});

var header_cnt = 0;
$("#add_api_headers").click(function () {
    header_cnt++;
    add_header(header_cnt, '', '')
});
/* js for front page end */

/* js for http simulator start */
function is_empty(str) {
    if (str == null || str == '' || str == 'undefined') {
        return false;
    }
    return true;
}
function get_all_params() {
    var params = {};
    $('.params_p').each(function () {
        var cnt = $(this).attr('cnt');
        var name = $(this).find("input[name=p_name_" + cnt + "]").val();
        var value = $(this).find("input[name=p_value_" + cnt + "]").val();
        params[name] = value;
    });
    return JSON.stringify(params);
}

function get_all_headers() {
    var headers = {};
    $('.headers_p').each(function () {
        var cnt = $(this).attr('cnt');
        var name = $(this).find("input[name=h_name_" + cnt + "]").val();
        var value = $(this).find("input[name=h_value_" + cnt + "]").val();
        headers[name] = value;
    });
    return JSON.stringify(headers);
}

$('#sendApi').click(function () {

    var api_name = $('#api_name').val();
    var http_method = $('#http_method').val();
    var api_url = $('#api_url').val();
    var params = get_all_params();
    //alert(params.toString());
    var result_text = null;
    $.post('/send', {
        url: api_url,
        method: http_method,
        params: params,
        headers: headers
    }, function (data) {
        data = JSON.parse(data);
        $('#response_header').val(data['header']);
        $('#response_body').val(data['body']);
    })
});

$('#saveApi').click(function () {
    var group_id = $('#group_id').val();
    var api_name = $('#api_name').val();
    var http_method = $('#http_method').val();
    var api_url = $('#api_url').val();
    var response_success = $('#response_success').val();
    var response_failed = $('#response_failed').val();
    var params = get_all_params();
    //alert(api_name+" "+http_method+" "+api_url+" "+params+" "+response_success+" "+response_failed);
    $.post('/api-manage/addApi', {
        group_id:group_id,
        name:api_name,
        url: api_url,
        method: http_method,
        params: params,
        success_response: response_success,
        fail_response: response_failed
    },function (data) {
        window.location="/api-manage";
    })
});

$('#deleteApi').click(function () {
    var api_id = $('#api_id').val();
    //alert(api_id);
    $.post('/aaaaaa', {
        id: api_id,
        method: http_method,
        params: params
    }, function (data) {

    },function (data) {
        alert(data);
    })
});
$('#updateApi').click(function () {
    var api_id = $('#api_id').val();
    var api_name = $('#api_name').val();
    var http_method = $('#http_method').val();
    var api_url = $('#api_url').val();
    var response_success = $('#response_success').val();
    var response_failed = $('#response_failed').val();
    var params = get_all_params();
    //alert(api_id+" "+api_name+" "+http_method+" "+api_url+" "+params+" "+response_success+" "+response_failed);
    $.post('/aaaaaa', {
        id: api_id,
        name:api_name,
        url: api_url,
        method: http_method,
        params: params,
        succ_res: response_success,
        fail_res: response_failed
    }, function (data) {

    },function (data) {
        alert(data);
    })
});
/* js for http simulator end */
