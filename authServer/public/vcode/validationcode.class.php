<?php
	class ValidationCode {
		private $width;    //宽
		private $height;   //高
		private $codeNum;	   //数量
		private $code;    //验证码
		private $image;     //图像的资源
		private $disturbColorNum;

		//构造方法， 三个参数
		function __construct($width=120, $height=30, $codeNum=4) {
			$this->width = $width;
			$this->height = $height;
			$this->codeNum = $codeNum;
			$this->checkCode = $this->createCheckCode(); //调用自己的方法
			$this->disturbColorNum=$width*$height/15;
			$number=floor($width*$height/15);//面积与干扰原素数量对应

			if($number > 100-$codeNum){
				$this->disturbColorNum=100-$codeNum;
			}else{
				$this->disturbColorNum=$number;
			}
		}

		//输出图像
		function showImage() {
			//创建背景 (颜色， 大小， 边框)
			$this->createImage();

			//干扰元素(点， 线条)
			$this->setDisturbcolor();

			//画字 (大小， 字体颜色)
			$this->outputText();

			//输出图像
			$this->outputImage();
		}

		//获取字符的验证码， 用于保存在服务器中
		function getCheckCode() {
			return $this->checkCode;
		}

		//创建背景
		private function createImage() {
			//创建资源
			$this->image = imagecreatetruecolor($this->width, $this->height);
			//设置随机的背景颜色
			$backColor =  imagecolorallocate($this->image, rand(250, 255), rand(250, 255), rand(250, 255)); 
			//设置背景填充
			imagefill($this->image, 0, 0, $backColor);
			//画边框
			$bordercolor =  imagecolorallocate($this->image, 130, 130, 130);
			imagerectangle($this->image, 0, 0, $this->width-1, $this->height-1, $bordercolor);
			
			//画矩形并填充
			$rectanglecolor = imagecolorallocate($this->image, rand(100,250),rand(100,200),rand(100,250));
			$x1 = rand(1,40);
			$y1 = rand(1,10);
			$x2 = rand(60,119);
			$y2 = rand(20,29);
			imagefilledrectangle($this->image,$x1,$y1,$x2,$y2,$rectanglecolor);
		}

		//设置干扰元素
		private function setDisturbColor() {
			//加上点数
			for($i=0; $i<$this->disturbColorNum; $i++) {
				$color= imagecolorallocate($this->image, rand(100, 255), rand(100, 255), rand(100, 255)); 
				imagesetpixel($this->image, rand(1, $this->width-2), rand(1, $this->height-2), $color);
			}
	
			//加线条
			for($i=0; $i<7; $i++) {
				$color= imagecolorallocate($this->image, rand(0, 255), rand(0, 200), rand(0, 255)); 
				imagearc($this->image,rand(-10, $this->width+10), rand(-10, $this->height+10), rand(30, 200), rand(30, 200), 30,30, $color);
			}
		}


		//生成验证码字符串
		private function createCheckCode() {
/*			$code = "23456789abcdefghijkmnpqrstuvwxyABCDEFGHIJKLMNPQRSTUVWXY";
			$string = "";

			for($i=0; $i < $this->codeNum; $i++) {
				$char=$code{rand(0, strlen($code)-1)};	
				$string .=$char;
			}
			return $string;
*/
			$pb = '';
			$fp = @fopen('/dev/urandom','rb');
			if($fp != FALSE){
				$i = 0;
				while($i<4){
					$pp = @fread($fp,1);
					if((($pp>='0') && ($pp<='9')) || (($pp>='a')&&($pp<='z')) || (($pp>='A')&&($pp<='Z'))){
						$pb .= $pp;
						$i++;
					}
				}
				@fclose($fp);
				return $pb;
			}

		}

		//画字
		private function outputText() {
			for($i=0; $i<$this->codeNum; $i++) {
			
				$fontcolor= imagecolorallocate($this->image, rand(0, 100), rand(0, 100), rand(0, 100)); 
				
				$fontsize=rand(8,10);  //字体大小

				$x = floor($this->width/$this->codeNum)*$i+10; //水平位置
				$y = rand(1, imagefontheight($fontsize)-3);

				//画出每个字符
				imagechar($this->image, $fontsize, $x, $y, $this->checkCode{$i}, $fontcolor);

			}
		}

		//输出图像
		private function outputImage() {
			if(imagetypes() & IMG_GIF) {
   				 header("Content-type: image/gif");
    				 imagegif($this->image);
			}else if(function_exists("imagejpeg")) {
   				 header("Content-type: image/jpeg");
   				 imagegif($this->image);
			}else if(imagetypes() & IMG_PNG) {
   				 header("Content-type: image/png");
    				 imagegif($this->image);
			}else if(imagetypes() & IMG_WBMP) {
					 header("Content-type: image/vnd.wap.wbmp");
    				 imagegif($this->image); 			
			}else {
  				  die("No image support in this PHP server");
			} 
		}

		//用于自动销毁图像资源
		function __destruct() {
			imagedestroy($this->image);
		}

	}
