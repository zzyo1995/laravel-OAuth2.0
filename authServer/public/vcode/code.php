<?php
	//开启session
	session_start();

	include "validationcode.class.php";
	//构造方法
	$vcode = new ValidationCode(125, 35, 4);
	//将验证码图片输出
	$vcode->showImage();
	//将验证码放到服务器自己的空间保存一份
	$_SESSION['code'] = $vcode->getCheckCode();
?>
