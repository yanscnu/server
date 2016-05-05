<?php
	if (!session_id()) {
		session_start();
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
		<link rel="stylesheet" type="text/css" href="../css/basic.css"/>
		<link rel="stylesheet" type="text/css" href="../../include/css/Font-Awesome-3.2.1/css/font-awesome.min.css"/>
	</head>
	<body style="background-color: #2D83EA;">
		<div class="header">
			<div class="header-left">
				<span><a href="../index.php" target="new"><strong>DOERS学习平台管理系统</strong></a></span>
			</div>
			<div class="header-center" >
				<ul style=" display:none;">
					<li><a href="">数据采集</a></li>
					<li><a href="">申请审批</a></li>
					<li><a href="">通知公告</a></li>
					<li><a href="">统计分析</a></li>
					<li><a href="">统计分析</a></li>
					<li><a href="">统计分析</a></li>
				</ul>
			</div>
			<div class="header-right">
				<span class="icon"><i class="icon-user icon-large"></i></span>
				<span class="name">欢迎您，
					<?php 
						if(isset($_SESSION['user_name'])){
							echo $_SESSION['user_name'];
						}
					?>
				</span>
			</div>
		</div>
	</body>
</html>
