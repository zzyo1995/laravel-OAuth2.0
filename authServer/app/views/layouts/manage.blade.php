<!DOCTYPE html>
<html lang="zh_CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>
        @section('title')
            管理 < 用户认证/授权服务器原型测试
        @show
    </title>

    <!-- CSS are placed here -->
    {{ HTML::style('css/bootstrap.css') }}
    {{ HTML::style('css/font-awesome.min.css') }}
    {{ HTML::style('css/admin.css') }}
    {{ HTML::style('css/jquery.Jcrop.css') }}
    {{ HTML::style('css/org-add-user.css') }}

</head>

<body>

<div id="wrapper">
    <!-- Sidebar -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header" >
            <button type="button" class="navbar-toggle" data-toggle="offcanvas">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
			<a class="navbar-brand" href="/">
				<img src="/img/logo.ico"/>
				<span>&nbsp;退出管理</span>
			</a>
        </div>
        <div class="offcanvas-left">
            <ul class="nav navbar-nav side-nav">
                @if ($nav_active == "home")<li class="active">@else<li>@endif<a href={{ URL::secure('manage'); }}><i class="menu-image fa fa-dashboard"></i>首页</a></li>
                @if ($nav_active == "companies")<li class="active">@else<li>@endif<a href={{ URL::secure('manage/companies'); }}><i class="menu-image fa fa-user"></i>人员管理</a></li>
                @if ($nav_active == "projectGroup")<li class="active">@else<li>@endif<a href={{ URL::secure('manage/projectGroup'); }}><i class="menu-image fa fa-sitemap"></i>组管理</a></li>
                {{--@if ($nav_active == "check")<li class="active">@else<li>@endif<a href={{ URL::secure('manage/check'); }}><i class="menu-image fa fa-group"></i>审核</a></li>--}}
{{--                @if ($nav_active == "resources")<li class="active">@else<li>@endif<a href={{ URL::secure('admin/resources'); }}><i class="menu-image fa glyphicon-cloud"></i>资源服务器管理</a></li>
                @if ($nav_active == "scopes")<li class="active">@else<li>@endif<a href={{URL::secure('admin/scopes');}}><i class="menu-image fa fa-font"></i>权限管理</a></li>
                				@if ($nav_active == "t2")<li class="active">@else<li>@endif<a href="bootstrap-elements.html"><i class="menu-image fa fa-desktop"></i>Bootstrap Elements</a></li>
                                @if ($nav_active == "t3")<li class="active">@else<li>@endif<a href="bootstrap-grid.html"><i class="menu-image fa fa-wrench"></i>Bootstrap Grid</a></li>
                                @if ($nav_active == "t4")<li class="active">@else<li>@endif<a href="blank-page.html"><i class="menu-image fa fa-file"></i>Blank Page</a></li>
                                <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="menu-image fa fa-caret-square-o-down"></i>Dropdown <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Dropdown Item</a></li>
                                    <li><a href="#">Another Item</a></li>
                                    <li><a href="#">Third Item</a></li>
                                    <li><a href="#">Last Item</a></li>
                                </ul>
                                </li>--}}
            </ul>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <!-- <div class="collapse navbar-collapse"> -->
        {{--		<div>
                    <ul class="nav navbar-nav navbar-right navbar-user">
                        <li class="dropdown messages-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <span class="badge">7</span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">7 New Messages</li>
                            <li class="message-preview">
                                <a href="#">
                                    <span class="avatar"><img src="http://placehold.it/50x50"></span>
                                    <span class="name">John Smith:</span>
                                    <span class="message">Hey there, I wanted to ask you something...</span>
                                    <span class="time"><i class="fa fa-clock-o"></i> 4:34 PM</span>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li class="message-preview">
                            <a href="#">
                                <span class="avatar"><img src="http://placehold.it/50x50"></span>
                                <span class="name">John Smith:</span>
                                <span class="message">Hey there, I wanted to ask you something...</span>
                                <span class="time"><i class="fa fa-clock-o"></i> 4:34 PM</span>
                            </a>
                            </li>
                            <li class="divider"></li>
                            <li class="message-preview">
                            <a href="#">
                                <span class="avatar"><img src="http://placehold.it/50x50"></span>
                                <span class="name">John Smith:</span>
                                <span class="message">Hey there, I wanted to ask you something...</span>
                                <span class="time"><i class="fa fa-clock-o"></i> 4:34 PM</span>
                            </a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="#">View Inbox <span class="badge">7</span></a></li>
                        </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->--}}
    </nav>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <!-- Success-Messages -->
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h4>操作成功</h4>
                        {{{ $message }}}
                    </div>
                @elseif ($message = Session::get('info'))
                    <div class="alert alert-info alert-block">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h4>提示</h4>
                        {{{ $message }}}
                    </div>
                @elseif ($message = Session::get('warning'))
                    <div class="alert alert-warning alert-block">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h4>警告</h4>
                        {{{ $message }}}
                    </div>
                @elseif ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h4>错误</h4>
                        {{{ $message }}}
                    </div>
                @endif
                <h1>@yield('caption')</h1>

                <div id="page-content">
                    @yield('content')
                </div>
            </div>
        </div><!-- /.row -->

    </div><!-- /#page-wrapper -->

</div><!-- /#wrapper -->

<!-- Scripts are placed here -->
{{ HTML::script('js/jquery.v1.8.3.min.js') }}
{{ HTML::script('js/bootstrap.min.js') }}
{{ HTML::script('js/jquery.Jcrop.js') }}
<script type='text/javascript'>
    $(document).ready(function() {

        var select = document.getElementById("state_select");
        var state = $('#state').val();
        if(select != "undefined" && select != null){
            for(var i=0; i<select.options.length; i++){
                if(select.options[i].value == state){
                    select.options[i].selected = true;
                    break;
                }
            }
        }

        $('#state_select').change(function(){
            $('#state').val($('#state_select').children('option:selected').val());
            $('#hiddenForm').submit();
        });

        var curTr;

        $("#allCompanyTable tbody tr").on('click',function(){
            //	 alert($(this).find("td").eq(1).text()) ;
            curTr = $(this) ;
            $('#companyModal input[name="username"]').val(curTr.find("td").eq(0).text()) ;//设置模态对话框中对应字段的信息
            $('#companyModal input[name="email"]').val(curTr.find("td").eq(1).text()) ;
            $('#companyModal textarea[name="reason"]').val("") ;
//            $('#companyModal textarea[name="reason"]').val(curTr.find("td").eq(2).text()) ;
//                var selectedText = curTr.find("td").eq(1).text() ;
//                if(selectedText == "审批成功")
//                    $('#companyModal select[name="state"]').find("option[value='success']").attr('selected','selected');
//                else
//                if(selectedText == "审批失败")
//                    $('#companyModal select[name="state"]').find("option[value='fail']").attr('selected','selected');
//                else
//                if(selectedText == "未审批")
            $('#companyModal select[name="state"]').find("option[value='undo']").attr('selected','selected');
        });

        $('#companyModal').on('show.bs.modal',function(e){
        }) ;

        $('#checkBtn').on('click',function(e){ /*捕获到submitBtn的点击事件，执行function*/
            var email = $('#companyModal input[name="email"]').val() ;
            var state = $('#companyModal select[name="state"] option:selected').val();
            var stateText = $('#companyModal select[name="state"] option:selected').text();
            var reason = $('#companyModal textarea[name="reason"]').val();
			var maxChars = 255;//最多字符数 
    		if (reason.length > maxChars)
			{
				alert("输入的备注长度不能超过255个字符,请重新输入!");
                //清空模态框数据
                $('#companyModal input[name="name"]').val("") ;
                $('#companyModal input[name="created_at"]').val("") ;
                $('#companyModal textarea[name="reason"]').val("") ;
				return false;
			}
            if(state != "undo"){
                $.ajax( {
                    url:'/manage/check',// 跳转到 action
                    data:{
                        email : email,
                        company_id : $('#id').val(),
                        state : state,
                        reason : reason
                    },
                    contentType : "application/x-www-form-urlencoded;charset=utf-8",
                    type:'get',
                    cache:false,
                    dataType:'text',
                    success:function(data) {
                        //成功，触发模态对话框的点击事件，销毁模态对话框
                        $('.modal-footer button[data-dismiss="modal"]').click() ;
                        //修改表格数据
//                        curTr.find("td").eq(1).text(stateText) ;
//                        curTr.find("td").eq(4).text(reason) ;
                        curTr.remove();
                        //清空模态框数据
                        $('#companyModal input[name="name"]').val("") ;
                        $('#companyModal input[name="created_at"]').val("") ;
                        $('#companyModal textarea[name="reason"]').val("") ;
                    },
                   error : function() {
                        alert("异常！");
                    }
                });
            } else {
                //成功，触发模态对话框的点击事件，销毁模态对话框
                $('.modal-footer button[data-dismiss="modal"]').click() ;
                //清空模态框数据
                $('#companyModal input[name="name"]').val("") ;
                $('#companyModal input[name="created_at"]').val("") ;
                $('#companyModal textarea[name="reason"]').val("") ;
            }
        }) ;

        $('input[name="delbtn"]').click(function(){

            var userId = $(this).attr("userid");
            var companyId = $(this).attr("companyid");

            $.ajax( {
                url:'/manage/deleteUser',// 跳转到 action
                data:{
                    user_id : userId,
                    company_id : companyId
                },
                contentType : "application/x-www-form-urlencoded;charset=utf-8",
                type:'POST',
                cache:false,
                dataType:'text',
                success:function(data) {
                    //成功,删除该条记录
                    $('#'+userId).remove();
                },
                error : function() {
                    alert("异常！");
                }
            });
        });


        /**
         * 多选框事件
         */

        $('#select_a').click(function(){
                    if ($("#select_a").attr("checked")) {
                        $(":checkbox").attr("checked", true);
                    } else {
                        $(":checkbox").attr("checked", false);
                    }
                }
        );

        $("[name='select_user']").click(function(){
            if ($(this).attr("checked")) {
                $(this).attr("checked", true);
            } else {
                $(this).attr("checked", false);
            }
        });

        /**
         * 获取复选框并提交
         */
        $("#add_member").click(function(){
            var uid = "";
            $("[name='select_user'][checked]").each(function(){
                if(uid == ""){
                    uid += $(this).val();
                } else {
                    uid += "," + $(this).val();
                }
            })

            if(uid == "") {
                alert("请先选择添加的成员!");
                return false;
            }
            $("#uid").val(uid);
            $("#add_member_form").submit();

        });

    });
</script>
