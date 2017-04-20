<!DOCTYPE html>
<html lang="zh_CN">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>重置密码</h2>

		<div>
            <p>您的账号启动了密码重置流程，如果您本人没有进行该操作，请忽略本邮件。</p>
			<p>点击<a href="{{ URL::to('password/reset', array($token)) }}">此链接</a>，或将下面的地址复制到浏览器中打开以重新设置密码：</p>
            <p>{{ URL::to('password/reset', array($token)) }}</p>
		</div>
	</body>
</html>