<html>
	<head>
	<meta charset="utf-8">
		<title>
			@section('title')
				网络账号授权页面模板
			@show
		</title>
		{{ HTML::style('css/bootstrap.css') }}
		{{ HTML::style('css/font-awesome.min.css') }}
		{{ HTML::style('css/admin.css') }}
		{{ HTML::style('css/jquery.Jcrop.css') }}
		{{ HTML::script('js/jquery.v1.8.3.min.js') }}
		{{ HTML::script('js/bootstrap.min.js') }}
		{{ HTML::script('js/jquery.Jcrop.js') }}
	</head>
	<body>
		<script type="text/javascript">
			$(document).ready(function() {
				$("input[name='authorize']").css('margin-left','20px') ;
			}) ;
		</script>
		<div class="container" style="width:580px">
			<header style="text-align: center"><h2>网络账号授权登陆页面</h2></header>
			<div class="row">
			@section('content')
			<!-- 

			 -->
			@show
			</div>
			<footer style="text-align: center;height:40px">提示：为保障帐号安全，请认准本页URL地址必须以 api 开头</footer>
		</div>
	</body>
</html>
