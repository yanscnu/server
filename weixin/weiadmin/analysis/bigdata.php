<?php
	require ('../common/init.php');
	$page_name = '数据统计 > 用户大数据';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script src="../../include/js/jquery-1.5.2.min.js"></script>
	<script type="text/javascript" src="../../include/js/Highcharts-4.1.9/highcharts.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/basic.css"/>
	<?php require('analysis.php'); ?>
	<title>分析统计</title>
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
<div id="container1" >性别比例</div>
<div id="container2" >省份分布</div>        
<div id="container3" >用户性别</div>  
<div id="container4" >用户年龄层次</div>
</body>
</html>