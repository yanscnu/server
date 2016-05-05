<?php	
	
	code();
function code($width = 75, $height = 25, $code_len = 4, $border_flag = false) {
	$code_string = "ABCDEFGHIJKLMNOPQRSTUVWXZY1234567890";
	$str_len = strlen ( $code_string );
	$code = '';
	for($i = 0; $i < $code_len; $i ++) {
		$code .= $code_string [mt_rand ( 0, $str_len - 1 )];
	}
	if (! session_id ()) {
		session_start (array('cookie_lifetime'=>1800));
	}
	$_SESSION ['checkcode'] = strtoupper ( $code );

	// 创建图像
	$image = imagecreatetruecolor ( $width, $height );

	// 填充
	$white = imagecolorallocate ( $image, 255, 255, 255 );
	imagefill ( $image, 0, 0, $white );

	if ($border_flag) {
		// 画矩形外边框
		$black = imagecolorallocate ( $image, 0, 0, 0 );
		imagerectangle ( $image, 0, 0, $width - 1, $height - 1, $black );
	}

	// 随机画6条线
	for($i = 0; $i < 6; $i ++) {
		$rand_color = imagecolorallocate ( $image, mt_rand ( 0, 255 ), mt_rand ( 0, 255 ), mt_rand ( 0, 255 ) );
		$x1 = mt_rand ( 1, $width - 1 );
		$y1 = mt_rand ( 1, $height - 1 );
		$x2 = mt_rand ( 1, $width - 1 );
		$y2 = mt_rand ( 1, $height - 1 );
		imageline ( $image, $x1, $y1, $x2, $y2, $rand_color );
	}

	// 随机雪花
	for($i = 0; $i < 50; $i ++) {
		$rand_color = imagecolorallocate ( $image, mt_rand ( 200, 255 ), mt_rand ( 200, 255 ), mt_rand ( 200, 255 ) );
		$x = mt_rand ( 1, $width - 1 );
		$y = mt_rand ( 1, $height - 1 );
		imagestring ( $image, 1, $x, $y, '*', $rand_color );
	}

	// 画验证码
	$width_each = $width / $code_len;
	for($i = 0; $i < $code_len; $i ++) {
		$x = mt_rand ( $width_each * $i + 1, $width_each * ($i + 1) - imagefontwidth ( 5 ) );
		$y = mt_rand ( 2, $height - imagefontheight ( 5 ) );
		$rand_color = imagecolorallocate ( $image, mt_rand ( 0, 100 ), mt_rand ( 0, 100 ), mt_rand ( 0, 100 ) );
		imagechar ( $image, 5, $x, $y, $_SESSION ['checkcode'] [$i], $rand_color );
	}

	// 输出图像
	header ( 'Content-Type:image/png' );
	imagepng ( $image );
	// 销毁图像
	imagedestroy ( $image );
}