/**
 * Created by zzyo on 2017/3/1.
 */
/* js for front page start */

function del_param(obj) {
    $(obj).parent().parent().parent().parent().remove();
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
        '<input class="form-control" type="text" name="p_name_' + cnt + '"  value="' + name + '"/>' +
        '</td>' +
        '<td>' +
        '<div class="row">' +
        '<div class="col-md-8"> <input class="form-control" type="text" name="p_value_' + cnt + '" value="' + value + '"/></div>' +
        '<div class="col-md-4"><button class="btn btn-warning" onclick="del_param(this);" type="button">删除参数</button></div>' +
        '</div>' +
        '</td>' +
        '</tr>');
}

var param_cnt = 0;
$("#add_url_parameter").click(function () {
    param_cnt++;
    add_parameter(param_cnt, '', '');
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


$('#sendApi').click(function () {
    var http_method = $('#http_method').val();
    var api_url = $('#api_url').val();
    var params = get_all_params();
    //alert(params.toString());
    var result_text = null;
    $.post('/api-manage/test', {
        url: api_url,
        method: http_method,
        params: params,
    }, function (data) {
        //data = JSON.parse(data);
        $('#response_body').val(data);
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
        window.location.reload();
    })
});

$('#deleteApi').click(function () {
    var api_id = $('#api_id').val();
    $.post('/api-manage/deleteApi', {
        api_id: api_id
    }, function (data) {
        alert(data);
        window.location.reload();
    })
});
$('#updateApi').click(function () {
    var api_id = $('#api_id').val();
    var group_id = $('#group_id').val();
    var api_name = $('#api_name').val();
    var http_method = $('#http_method').val();
    var api_url = $('#api_url').val();
    var response_success = $('#response_success').val();
    var response_failed = $('#response_failed').val();
    var params = get_all_params();
    //alert(api_id+" "+api_name+" "+http_method+" "+api_url+" "+params+" "+response_success+" "+response_failed);
    $.post('/api-manage/updateApi', {
        group_id:group_id,
        api_id: api_id,
        name:api_name,
        url: api_url,
        method: http_method,
        params: params,
        success_response: response_success,
        fail_response: response_failed
    }, function (data) {
        alert(data);
        window.location.reload();
    })
});
/* js for http simulator end */
