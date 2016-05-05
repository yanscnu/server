<?php
	require ('../common/init.php');
	$page_name = '数据统计 > 用户个人情况分析';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>分析</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="../css/basic.css"/>
	<script type="text/javascript" src="../../include/js/jquery-1.5.2.min.js"></script>
	<script type="text/javascript" src="../../include/js/Highcharts-4.1.9/highcharts.js"></script>
		<?php require('analysis.php'); ?>
		
	<style type="text/css">
		#container1,#container2,#container3,#container4{
			width: 40%;
			float: left;
			margin: 10px 0 10px 7%;
		}
	</style>
</head>

<body class="bg">

<?php include ROOT_PATH.'weiadmin/common/content-header.html';?>

<div id="container1">文章浏览数</div>
<div id="container2">文章形式偏好</div>
<div id="container3">文章类别偏好</div>
<div id="container4">浏览时长</div>

</body>
</html>
