<html>
	<head>
		<title>
		@section('title')
		@show
        </title>
        {{ HTML::style('css/bootstrap.css') }}
        {{ HTML::style('css/bootstrap-responsive.css') }}
        {{ HTML::style('css/font-awesome.min.css') }}
        {{ HTML::script('js/jquery-1.10.2.js') }}
		{{ HTML::script('js/bootstrap.js') }}
	</head>
    <body>
    	<script type="text/javascript">
				 function errorAlert()
				 {
				     $("#errorAlert").alert('close');
				 }
				 function successAlert()
				 {
				     $("#successAlert").alert('close');
				 }
				 $(document).ready(function(){
					 $("#netaccount_login").click(function(){
						 location.href="netaccount_login" ;
					}) ;
				}) ;
		</script>
{{--    	<header style="height: 5%;background-color:silver">
    		<div class="collapse navbar-collapse" id="top-navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        @if ( Auth::guest() )
                        <li>{{ HTML::secureLink('login', '登录') }}</li>
                        <li>{{ HTML::secureLink('register', '注册') }}</li>
                        @else
                        <li>{{ HTML::secureLink('users/'.Auth::user()->id, '你好，'.Auth::user()->username) }}</li>
                        <li>{{ HTML::secureLink('logout', '退出') }}</li>
                        @endif
                    </ul>
			</div>
    	</header>--}}
    	
    	<div class="container-fluid" style="height:90%;padding:0px">
    		@if ( isset($success) )
		    <div id="successAlert"  class="alert alert-success fade in row">
		    	<div class="offset8">
					<button id='successAlert' type="button" class="close" onclick="successAlert()" aria-hidden="true">&times;</button>
			    	<h4><strong>Success</strong></h4> 
			    	<p> {{ $success }}</p>
		    	</div>
			</div>
    		@endif
    		@if ( isset($fail) )
    		<div id="errorAlert"  class="alert alert-danger fade in row">
    			<div class="offset8">
					<button id='alert1' type="button" class="close" onclick="errorAlert()" aria-hidden="true">&times;</button>
				    <h4><strong>Error</strong></h4> 
				    <p> {{ $fail }}</p>
			    </div>
			</div>
			@endif
			@section('content')
       	 	@show    	
    	</div>
    	<footer style="height: 5%;background-color:silver">尾部</footer>
    </body>
</html>