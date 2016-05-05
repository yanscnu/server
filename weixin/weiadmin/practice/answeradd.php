<?php
	require '../common/init.php';
	if (!isset($_GET['pid'])) {
		exit('非法访问');
	}
	$pid = $_GET['pid'];
	$sql = "SELECT `practice_content` FROM `practice` WHERE `pid`={$pid}";
	$result = mysql_query($sql) or die(mysql_error());
	if (mysql_num_rows($result) <= 0) {
		exit('异常！！！');
	}
	$row = mysql_fetch_assoc($result);
?>


<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title></title>
	<script src="../../include/js/jquery-1.5.2.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/basic.css"/>
	<style type="text/css">
		.answeradd{
			width: 70%;
			margin: 10px auto;
		}
		.operation{
			padding: 20px 0 0 0;
		}
		.operation .button{
			border: none;
			outline: none;
			width: 60px;
			height: 30px;
			line-height: 30px;
			cursor: pointer;
		}
		.operation input[type=submit]:hover{
			background-color: #FF6600;
			color: #FFFFFF;
		}
		.operation input[type=reset]:hover{
			background-color: #EA2A2A;
			color: #FFFFFF;
		}
	</style>
</head>
<body class="bg">

<?php include ROOT_PATH.'weiadmin/common/content-header.html';?>
<form action="practiceaction.php?act=answer_add&pid=<?php echo $pid;?>" method="post">
	<div class="answeradd">
		<h2>添加习题答案</h2>
		<div >
			<?php echo $row['practice_content']?>
		</div>
		<div class="operation">
			<input type="submit" class="button" value="提交"/>&nbsp;&nbsp;
			<input type="reset" class="button" value="重置"/>
		</div>
	</div>
</form>
</body>
</html>