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
</head>

<body>

<div id="wrapper">
	<!-- Sidebar -->
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
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
				@if ('admin' == Auth::user()->username)
					@if ($nav_active == "home")<li class="active">@else<li>@endif<a href={{ URL::secure('admin/manage'); }}><i class="menu-image fa fa-dashboard"></i>首页</a></li>
					@if ($nav_active == "users")<li class="active">@else<li>@endif<a href={{ URL::secure('admin/users'); }}><i class="menu-image fa fa-user"></i>用户管理</a></li>
			  <!--  @if ($nav_active == "clients")<li class="active">@else<li>@endif<a href={{ URL::secure('admin/clients'); }}><i class="menu-image fa fa-sitemap"></i>客户端管理</a></li>  -->
			  <!--  @if ($nav_active == "groups")<li class="active">@else<li>@endif<a href={{ URL::secure('admin/groups'); }}><i class="menu-image fa fa-group"></i>组管理</a></li>  -->
			  <!--  @if ($nav_active == "resources")<li class="active">@else<li>@endif<a href={{ URL::secure('admin/resources'); }}><i class="menu-image fa glyphicon-cloud"></i>资源服务器管理</a></li> -->
					@if ($nav_active == "scopes")<li class="active">@else<li>@endif<a href={{URL::secure('admin/scopes');}}><i class="menu-image fa fa-font"></i>权限管理</a></li>
					@if ($nav_active == "roles")<li class="active">@else<li>@endif<a href={{URL::secure('admin/roles');}}><i class="menu-image fa fa-user"></i>用户类型管理</a></li>
					@if ($nav_active == "project_roles")<li class="active">@else<li>@endif<a href={{URL::secure('admin/project_roles');}}><i class="menu-image fa fa-tag"></i>组内角色管理</a></li>
		       <!-- @if ($nav_active == "company")<li class="active">@else<li>@endif<a href={{URL::secure('admin/company');}}><i class="menu-image fa fa-desktop"></i>组织结构管理</a></li>  -->
					@if ($nav_active == "applier")<li class="active">@else<li>@endif<a href={{ URL::secure('admin/applier') }}><i class="menu-image fa fa-wrench"></i>组织管理员审核</a></li>
				@endif
				@if ('sysadmin' == Auth::user()->username)
					@if ($nav_active == "home")<li class="active">@else<li>@endif<a href={{ URL::secure('sysadmin/manage'); }}><i class="menu-image fa fa-dashboard"></i>首页</a></li>
					@if ($nav_active == "users")<li class="active">@else<li>@endif<a href={{ URL::secure('sysadmin/users'); }}><i class="menu-image fa fa-user"></i>用户管理</a></li>
					@if ($nav_active == "clients")<li class="active">@else<li>@endif<a href={{ URL::secure('sysadmin/clients'); }}><i class="menu-image fa fa-sitemap"></i>客户端管理</a></li>
					@if ($nav_active == "company")<li class="active">@else<li>@endif<a href={{URL::secure('sysadmin/company');}}><i class="menu-image fa fa-desktop"></i>组织结构管理</a></li>
					@if ($nav_active == "applier")<li class="active">@else<li>@endif<a href={{ URL::secure('sysadmin/applier') }}><i class="menu-image fa fa-wrench"></i>组织管理员</a></li>
				@endif
{{--				@if ($nav_active == "t4")<li class="active">@else<li>@endif
<a href="blank-page.html"><i class="menu-image fa fa-file"></i>Blank Page</a></li>
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
	var curTr ;
	$('[data-toggle=offcanvas]').click(function() {
		$('.offcanvas-left').toggleClass('active');
	});
	$(function () { $("[data-toggle='tooltip']").tooltip(); });

	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		  e.target // activated tab
		  e.relatedTarget // previous tab
	});

	 $("#allResourceTable tbody tr").on('click',function(){
	//	 alert($(this).find("td").eq(1).text()) ;
		curTr = $(this) ;
		$('#myModal input[name="name"]').val(curTr.find("td").eq(0).text()) ;//设置模态对话框中对应字段的信息
		$('#myModal input[name="created_at"]').val(curTr.find("td").eq(3).text()) ;
		$('#myModal textarea[name="reason"]').val(curTr.find("td").eq(4).text()) ;
		var selectedText = curTr.find("td").eq(1).text() ;
		if(selectedText == "审批成功")
			$('#myModal select[name="status"]').find("option[value='success']").attr('selected','selected');
		else
			if(selectedText == "审批失败")
				$('#myModal select[name="status"]').find("option[value='fail']").attr('selected','selected');
			else
				if(selectedText == "未审批")
					$('#myModal select[name="status"]').find("option[value='undo']").attr('selected','selected');
     });

	$('#myModal').on('show.bs.modal',function(e){
	}) ;

	$('#submitBtn').on('click',function(e){ /*捕获到submitBtn的点击事件，执行function*/
		var name = $('#myModal input[name="name"]').val() ;
		var status = $('#myModal select[name="status"] option:selected').val();
		var statusText = $('#myModal select[name="status"] option:selected').text();
		var reason = $('#myModal textarea[name="reason"]').val();
		var aj = $.ajax( {    
 		    url:'/resources/{id}',// 跳转到 action
		    data:{ 
			    name : name,
			    status : status,
			    reason : reason
			},    
			contentType : "application/x-www-form-urlencoded;charset=utf-8",
		    type:'put',
		    cache:false,   
		    dataType:'text',    
		    success:function(data) {    
		       //成功，触发模态对话框的点击事件，销毁模态对话框
				$('.modal-footer button[data-dismiss="modal"]').click() ;
				//修改表格数据
				curTr.find("td").eq(1).text(statusText) ;
				curTr.find("td").eq(4).text(reason) ;
				//清空模态框数据
				$('#myModal input[name="name"]').val("") ;
				$('#myModal input[name="created_at"]').val("") ;
				$('#myModal textarea[name="reason"]').val("") ;
		     },    
		     error : function() {    
		          alert("异常！");    
		     }    
		});
	}) ;


	 $("#allCompanyTable tbody tr").on('click',function(){
	//	 alert($(this).find("td").eq(1).text()) ;
		curTr = $(this) ;
		$('#companyModal input[name="name"]').val(curTr.find("td").eq(0).text()) ;//设置模态对话框中对应字段的信息
		$('#companyModal input[name="created_at"]').val(curTr.find("td").eq(3).text()) ;
		$('#companyModal textarea[name="reason"]').val(curTr.find("td").eq(4).text()) ;
		var selectedText = curTr.find("td").eq(1).text() ;
		if(selectedText == "审批成功")
			$('#companyModal select[name="state"]').find("option[value='success']").attr('selected','selected');
		else
			if(selectedText == "审批失败")
				$('#companyModal select[name="state"]').find("option[value='fail']").attr('selected','selected');
			else
				if(selectedText == "未审批")
					$('#companyModal select[name="state"]').find("option[value='undo']").attr('selected','selected');
     });

	$('#companyModal').on('show.bs.modal',function(e){
	}) ;

	$('#checkBtn').on('click',function(e){ /*捕获到submitBtn的点击事件，执行function*/
		var name = $('#companyModal input[name="name"]').val() ;
		var state = $('#companyModal select[name="state"] option:selected').val();
		var stateText = $('#companyModal select[name="state"] option:selected').text();
		var reason = $('#companyModal textarea[name="reason"]').val();
		var aj = $.ajax( {
 		    url:'/company/{id}',// 跳转到 action
		    data:{
			    name : name,
			    state : state,
			    reason : reason
			},
			contentType : "application/x-www-form-urlencoded;charset=utf-8",
		    type:'put',
		    cache:false,
		    dataType:'text',
		    success:function(data) {
		       //成功，触发模态对话框的点击事件，销毁模态对话框
				$('.modal-footer button[data-dismiss="modal"]').click() ;
				//修改表格数据
				curTr.find("td").eq(1).text(stateText) ;
				curTr.find("td").eq(4).text(reason) ;
				//清空模态框数据
				$('#companyModal input[name="name"]').val("") ;
				$('#companyModal input[name="created_at"]').val("") ;
				$('#companyModal textarea[name="reason"]').val("") ;
				window.location.reload();
		     },
		     error : function() {
		          alert("异常！");
		     }
		});
	}) ;

	// 权限管理
 	$('#scopeTable tr td input').css('box-shadow','0px 0px 0px rgba(0, 0, 0, 0.075) inset') ;
	$('#scopeTable tr td input').live('focus',function(){
		if(("undefined" == typeof $(this).attr("readonly")) || ($(this).attr("readonly") == false))
		{
			$(this).css('box-shadow','0px 1px 1px rgba(0, 0, 0, 0.075) inset, 0px 0px 8px rgba(102, 175, 233, 0.6)') ;
		}
		else
			return ;
	}) ;
	$('#scopeTable tr td input').live('blur',function(){
		$(this).css('box-shadow','0px 0px 0px rgba(0, 0, 0, 0.075) inset') ;
	}) ;
	$('#scopeTable tr td input').live('change',function(){
		value = $(this).val() ;
		name = $(this).attr('name') ;
		id = $(this).parent().parent().children().eq(0).text() ;
		var aj = $.ajax( {
			url:'/scope/update',
			data:{
				name:name,
				value:value,
				id:id
				},
			contentType : "application/x-www-form-urlencoded;charset=utf-8",
			type:'post',    
		    cache:false,   
		    dataType:'text',  
		    success:function(data) {    
			    //信息修改成功
			     },    
		     error : function() {    
		          alert("服务器连接异常！");    
		     }    
		}) ;
	});
	$('button[name="scopeDelBtn"]').live('click',function(){
		var status = confirm("确认删除?");
		if (!status) {
			return false;
		}
		id = $(this).parent().parent().children().eq(0).text() ;
		tr = $(this).parent().parent() ;
		var aj = $.ajax({
			url:'/scope/delete',
			data:{
				id:id
				},
			contentType : "application/x-www-form-urlencoded;charset=utf-8",
			type:'post',    
		    cache:false,   
		    dataType:'text',  
		    success:function(data) {    
			    //信息修改成功
		    	tr.remove() ;
			 },    
		     error : function() {    
		          alert("服务器连接异常，权限删除失败！");    
		     }    
		});
	}) ;
	$('#scopeAdd').click(function(){
		scope = $('#scope').eq(0).val() ;
		name = $('#name').eq(0).val() ;
		description = $('#description').eq(0).val() ;
		var aj = $.ajax({
			url:'/scope/add',
			data:{
				scope:scope,
				name:name,
				description:description
				},
			contentType : "application/x-www-form-urlencoded;charset=utf-8",
			type:'post',    
		    cache:false,   
		    dataType:'text',  
		    success:function(data) {    
			    //信息修改成功
			    retVal = jQuery.parseJSON(data) ;
			    if(retVal.result == "success")
			    {
				    var tr = "<tr><td style=\"height:34px;padding:0px\">"+retVal.id+"</td><td style=\"height:34px;padding:0px\"><input class=\"form-control\" style=\"border: 0px solid rgb(241, 241, 241); box-shadow: rgba(0, 0, 0, 0.0745098) 0px 0px 0px inset; background-color: rgb(241, 241, 241);\" name=\"scope\" type=\"text\" value="+scope+"></td><td style=\"height:34px;padding:0px\"><input class=\"form-control\" style=\"border: 0px solid rgb(241, 241, 241); box-shadow: rgba(0, 0, 0, 0.0745098) 0px 0px 0px inset; background-color: rgb(241, 241, 241);\" name=\"name\" type=\"text\" value="+name+"></td><td style=\"height:34px;padding:0px\"><input class=\"form-control\" style=\"border: 0px solid rgb(241, 241, 241); box-shadow: rgba(0, 0, 0, 0.0745098) 0px 0px 0px inset; background-color: rgb(241, 241, 241);\" name=\"description\" type=\"text\" value="+description+"></td><td style=\"height:34px;padding:0px\"><button name=\"scopeDelBtn\" class=\"btn btn-danger btn-sm\" type=\"button\">删除</button></td></tr>" ;
				    $('#scopeTable').append(tr) ;
				    $('.close').click() ;
				}
			    else
			    {
 				    $.each(retVal,function(key,value){
					    alert(value) ;
					    return false ; //跳出循环，相当于break 
 					});
				}
			 },    
		     error : function() {    
		          alert("服务器连接异常，权限删除失败！");    
		     }    
		});
	}) ;

	//角色管理
 	$('#roleTable tr td input').css('box-shadow','0px 0px 0px rgba(0, 0, 0, 0.075) inset') ;
	$('#roleTable tr td input').live('focus',function(){
		if(("undefined" == typeof $(this).attr("readonly")) || ($(this).attr("readonly") == false))
		{
			$(this).css('box-shadow','0px 1px 1px rgba(0, 0, 0, 0.075) inset, 0px 0px 8px rgba(102, 175, 233, 0.6)') ;
		}
		else
			return ;
	}) ;
	$('#roleTable tr td input').live('blur',function(){
		$(this).css('box-shadow','0px 0px 0px rgba(0, 0, 0, 0.075) inset') ;
	}) ;
	$('#roleTable tr td input').live('change',function(){
		value = $(this).val() ;
		name = $(this).attr('name') ;
		id = $(this).parent().parent().children().eq(0).text() ;
		var aj = $.ajax( {
			url:'/role/update',
			data:{
				name:name,
				value:value,
				id:id
				},
			contentType : "application/x-www-form-urlencoded;charset=utf-8",
			type:'post',    
		    cache:false,   
		    dataType:'text',  
		    success:function(data) {    
			    //信息修改成功
			     },    
		     error : function() {    
		          alert("服务器连接异常！");    
		     }    
		}) ;
	});
	$('button[name="roleDelBtn"]').live('click',function(){
		var status = confirm("确认删除?");
		if (!status) {
			return false;
		}
		id = $(this).parent().parent().children().eq(0).text() ;
		tr = $(this).parent().parent() ;
		var aj = $.ajax({
			url:'/role/delete',
			data:{
				id:id
				},
			contentType : "application/x-www-form-urlencoded;charset=utf-8",
			type:'post',    
		    cache:false,   
		    dataType:'text',  
		    success:function(data) {    
			    //信息修改成功
		    	tr.remove() ;
			 },    
		     error : function() {    
		          alert("服务器连接异常，权限删除失败！");    
		     }    
		});
	}) ;
	
	var select = document.getElementById("admin_apply_state_select");
	var state = $('#admin_apply_state').val();
	if(select != "undefined" && select != null){
		for(var i=0; i<select.options.length; i++){
			if(select.options[i].value == state){
				select.options[i].selected = true;
				break;
			}
		}
	}

	$('#admin_apply_state_select').change(function(){
		$('#admin_apply_state').val($('#admin_apply_state_select').children('option:selected').val());
		$('#hiddenForm').submit();
	});

	/**
	 * 组织管理员审核
	 */
	$('input[name="check_apply"]').click(function(){
		var state = $(this).attr("state");
		var applyId = $(this).parent().parent().attr("id");
		$.ajax({
			url:'checkApply',
			data:{
				"applyId" :applyId,
				"state" : state
			},
			contentType : "application/x-www-form-urlencoded;charset=utf-8",
			type:'post',
			cache:false,
			dataType:'text',
			success:function(data) {
				//审核成功
				$('#'+applyId).remove();
			},
			error : function() {
				alert("审核失败！");
			}
		});
	});


 });
</script>
</body>
</html>
