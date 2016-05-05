<?php 
	require '../config/init.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="css/login.css"/>
		<script src="../include/js/jquery-1.5.2.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="../include/js/md5-min.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/login.js" type="text/javascript" charset="utf-8"></script>
		<title>用户登录</title>
	</head>
	<body>
		<div class="container">
	        <div class="top">
	        <img src="img/logintop.jpg" />
	        </div>
	        <form class="loginForm" id="loginForm" action="<?php echo __ROOT__; ?>home/Control/MemberControl.php?action=login" method="post">
	        <div class="student_name">
	        	<input type="text" class="input" name="student_name" id="student_name" placeholder="请输入用户名" 
	         		value="<?php if(isset($_GET['student_name'])){echo $_GET['student_name'];} ?>">
	         	<?php 
	            	if (isset($_GET['err_name_pass'])) {
	            		echo '<p class="error">'.urldecode($_GET['err_name_pass']).'</p>';
	            	}
	            ?>
	        </div>
	        
	        <div class="student_password">
	        	<input type="password" class="input" id="student_psw" name="student_psw" placeholder="请输入密码">
	        </div>
	        <div class="otherlink">
		        <a href="register.php">注册</a>
		        <a href="forget.php">忘记密码</a>
	        </div>
	        <div class="submitbtn">
	        	<button type="submit" id="subForm"  style="border-radius: 0px;"></button>
	        </div>
	        </form>
	        <div class="footer"><?php echo WEBSITE_NAME;?></div>
			
		</div>
	</body>
</html>
