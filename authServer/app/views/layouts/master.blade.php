<!DOCTYPE html>
<html lang="zh_CN">
    <head>
        <title>

            @section('title')
                用户认证/授权服务器原型测试
            @show
        </title>
        <meta charset="UTF-8">

        <!-- CSS are placed here -->
        {{ HTML::style('css/bootstrap.css') }}
        {{ HTML::style('css/bootstrap-responsive.css') }}
        {{ HTML::style('css/font-awesome.min.css') }}
		{{ HTML::style('css/jquery.Jcrop.css') }}
		{{ HTML::style('css/org-add-user.css') }}
        <style>
        @section('styles')
            body {
                padding-top: 60px;
            }
        @show
        </style>
    </head>

    <body>
        <!-- Navbar -->
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <!-- used as the toggle for collapsed navbar content -->
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#top-navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{{ URL::to('') }}}"><!--logo here-->AS-Prototype</a>
                </div>

                <!-- Everything you want hidden at 940px or less, place within here -->
                <div class="collapse navbar-collapse" id="top-navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="{{{ URL::to('') }}}">主页</a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        @if ( Auth::guest() )
                         <li>{{ HTML::secureLink('login', '登录') }}</li> 
                     <!--   <li>{{ HTML::secureLink('register', '注册') }}</li>-->
                        @else
			@if ( Auth::user()->username == 'admin')
			<li>{{ HTML::secureLink('admin/manage', '管理') }}</li>
                        <li>{{ HTML::secureLink('register', '注册') }}</li>
			@endif
			@if ( Auth::user()->username == 'sysadmin')
			<li>{{ HTML::secureLink('sysadmin/manage', '管理') }}</li>
                        <li>{{ HTML::secureLink('register', '注册') }}</li>
			@endif
			@if ( Auth::user()->username == 'safeadmin')
			<li>{{ HTML::secureLink('safeadmin/manage', '管理') }}</li>
			@endif
			@if ( Auth::user()->username == 'auditadmin')
			<li>{{ HTML::secureLink('auditadmin/manage', '管理') }}</li>
			@endif
			@if ( Auth::user()->username == 'admin')
					<!--	<li>{{ HTML::secureLink('company/create', '创建组织') }}</li> -->
						<li>{{ HTML::secureLink('company', '组织管理') }}</li>
			@endif
						<li>{{ HTML::secureLink('company/'.Auth::user()->id, '我的组织') }}</li>
                        <li>{{ HTML::secureLink('client-manage', '客户端') }}</li>
               	   <!-- <li>{{ HTML::secureLink('authServer-register', '注册资源服务器') }}</li> -->
                        <li>{{ HTML::secureLink('logout', '退出') }}</li>
						<li><a href={{ URL::secure('users/'.Auth::user()->id); }}><i class="menu-image fa fa-cog"></i>{{' '.Auth::user()->username }}</a></li>
                       	@endif
                    </ul>
                </div>


            </div>
        </div>

        <!-- Container -->
        <div class="container">

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

            <!-- Content -->
            @yield('content')

        </div>

        <!-- Scripts are placed here -->
        {{ HTML::script('js/jquery.v1.8.3.min.js') }}
        {{ HTML::script('js/bootstrap.min.js') }}
		{{ HTML::script('js/jquery.Jcrop.js') }}
		{{ HTML::script('js/jquery.form.js') }}
		<script type="text/javascript">
			if(!String.prototype.trim) {
  				String.prototype.trim = function () {
    			return this.replace(/^\s+|\s+$/g,'');
  				};
			}
			$("input[name=name]").on("input",function(evt){
  				if($(this).val().trim().length){
   				 	$("#sub").removeAttr("disabled");
  			}else{
    				$("#sub").prop("disabled","disabled");
  				}
			});


			$(document).ready(function(){
				$("input[name='client_type']").click(function(){
					if($(this).val() == "client")
						$("#redirect_url").hide() ;
					else	
						$("#redirect_url").show('slow') ;				
				}) ;

				var jcrop_api,//截图插件的对象
				boundx,//截取框的长度
				boundy,//截取框的宽度
				$preview = $("#preview-pane"),
				$pcnt = $("#preview-pane .preview-container"),
				$pimg = $("#preview-pane .preview-container img"),
				xsize = $pcnt.width(),//预览框的宽度
				ysize = $pcnt.height() ;//预览框的高度
				
				//是否已经加载过截图控件
				var isLoaded = 0 ;
				
				initImages() ;

				//初始化时图片未加载，选择隐藏图片控件，并提示对应的信息
				function initImages()
				{
					$("#user_face").hide() ;
					$pimg.hide() ;
				}
				
				//初始化裁剪框
				function initJcrop()
				{				
					$("#user_face").Jcrop({
							aspectRatio:1,//设置截图框长宽比例为1：1
							onSelect:updatePreview//设置截图狂的选择的后掉函数
						},function(){
							jcrop_api = this;

							//use api to get the real size of the miage
							var bounds = this.getBounds() ;//获取图片控件的大小
							boundx = bounds[0] ;
							boundy = bounds[1] ;
							jcrop_api.animateTo([0,0,200,200]) ;//设置初始化默认截图框的位置
							jcrop_api.setOptions({minSize:[50,50],maxSize:[300,300]}) ;//设置截图框的最大和最小尺寸
							$preview.appendTo(jcrop_api.ui.holder) ;
						});

				};


				//设置预览框中图片的样式为初始尺寸
				function initPreview()
				{
					$pimg.css({
						width:300+'px',
						height:300+'px',
						marginLeft:0+'px',
						marginTop:0+'px'
						});
				}
				
				//更新预览框中图片内容
				function updatePreview(c)
				{
					if(parseInt(c.w)>0)
					{
						var rx = xsize / c.w ;
						var ry = ysize / c.h ;

						x = c.x ;
						y = c.y ;
						w = c.w ;
						h = c.h ;

						//设置预览框中的图片样式
						$pimg.css({
							width:Math.round(rx*boundx)+'px',
							height:Math.round(ry*boundy)+'px',
							marginLeft:'-'+Math.round(rx*c.x)+'px',
							marginTop:'-'+Math.round(ry*c.y)+'px'
							});
					}

				};

				//对头像进行截取并保存
				$("#saveImg").click(function(){
					var aj = $.ajax({
						url:'/userDetial/saveUserImage',
						data:{
							x:x,
							y:y,
							w:w,
							h:h,
							path:filepath
							},
						contentType : "application/x-www-form-urlencoded;charset=utf-8",
						type:'post',    
					    cache:false,   
					    dataType:'text',  
					    success:function(data) {    
						    //信息修改成功
						    var retVal = jQuery.parseJSON(data) ;
						    if(retVal.result == "success")
						    {
							    //头像保存成功
							    alert("头像保存成功!") ;
							}
						    else
						    {
							    //头像保存失败
							    alert("头像保存失败，请重新截取!") ;
							}
						 },    
					     error : function() {    
					          alert("服务器连接异常，权限删除失败！");
					     }    
					});										
				});

				//文件上传的回调函数
				var options={
						success:function(data){
								if(data.result == "success")
								{
									//图片上传成功
									initPreview() ;
									
									filepath = data.filepath ;

									var height,width;
									
									if(data.width/data.height < 3/4 )
									{
										height = 400 ;
										width = Math.round(400*data.width/data.height) ;
									}
									else
									{
										width = 300 ;
										height = Math.round(300*data.height/data.width) ;
									}

									$("#user_face").parent().css({
										"border":"gray solid 0px"
										});
									
									//重新加载图片
									if(isLoaded == 0)
									{
										$("#user_face").attr("src",filepath) ;
										$("#user_face").css({
											"width":width+'px',
											"height":height+'px',
										});
									}
									else
									{
										jcrop_api.setImage(width,height,filepath) ;
										jcrop_api.animateTo([0,0,200,200]) ;//设置初始化默认截图框的位置
									}
									alert(filepath);
									$pimg.attr("src",filepath) ;
									
									if(isLoaded == 0)
									{
										initJcrop() ;
										$("#user_face").show() ;
										$("#updateImage1").hide() ;
										$("#updateImage2").hide() ;
										$pimg.show() ;
										isLoaded = 1; 
									}
									else
									{
										initJcrop() ;
										$("#user_face").show() ;
										$("#updateImage1").hide() ;
										$("#updateImage2").hide() ;
										$pimg.show() ;
									}
								}
								else
								{
									//图片上传失败
									alert(data.error_msg) ;
								}
							},
						error:function(data){
							alert("file send error!");
							}
						};

				//通过ajax提交文件上传的表单
				$("#fileUploadForm").ajaxForm(options);
				
				var userInfoUpdateCallback = {
						success:function(data){
							if(data.result == "success")
							{
								//修改用户信息成功
								alert("用户信息更新成功！") ;
							}
							else
							{
								//修改用户信息失败
								alert("用户信息更新失败，" + data.error_msg) ;
							}
						},
						error:function(data)
						{
							alert("更新用户信息失败!");
						}
				} ;
				$("#userDetailInfoForm").ajaxForm(userInfoUpdateCallback) ;
			}) ;
		</script>
    </body>
</html>
