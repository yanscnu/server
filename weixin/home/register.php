<?php
	//utf-8编码
	header('Content-Type:text/html;charset=utf-8');
	/**
	 * 或在head中加如下代码
	 * <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
	 */
	require '../config/init.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="css/register.css"/>
    <script src="../include/js/jquery-1.5.2.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="../include/js/md5-min.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/register.js" type="text/javascript" charset="utf-8"></script>
    <title>用户注册</title>
</head>
<body>
    <div class="container">
        <div class="top">
            <img src="img/register/registerlogo.jpg" />
        </div>
        <form id="registerForm" class="registerForm" action="<?php echo __ROOT__;?>home/Control/MemberControl.php?action=register" method="post">
            <div class="student_name">
                <input type="text" name="student_name" id="student_name" class="input" placeholder="请输入用户名" 
                		value="<?php if(isset($_GET['student_name'])){echo urldecode($_GET['student_name']);} ?>">
                <?php 
	            	if (isset($_GET['err_student_name'])) {
	            		echo '<p class="error">'.urldecode($_GET['err_student_name']).'</p>';
	            	}
            	?>
            </div>
            <div class="split">
                
            </div>
            <div class="student_password">
                <input type="password" id="student_psw" name="student_psw" class="input" autocomplete="off" placeholder="请输入密码">
                <?php 
	            	if (isset($_GET['err_pass'])) {
	            		echo '<p class="error">'.urldecode($_GET['err_pass']).'</p>';
	            	}
	            ?>
            </div>
            <div class="split">
                
            </div>
            <div class="student_password">
                <input type="password" id="repassword" name="repassword" class="input" placeholder="请再次输入密码">
            </div>
            <div class="split">
                
            </div>
            <div class="student_phone">
                <input type="password" id="phone" name="phone" class="input" placeholder="请输入手机号">
            </div>
            <div class="split">
                
            </div>
            <div class="student_code">
                <div class="code">
                    <img id="codeImg" src="<?php echo __ROOT__;?>home/include/code.php" /><br/>
                    <a id='changeCode' href="javascript:void(0);" 
                    		url="<?php echo __ROOT__;?>home/include/code.php">换一张</a>
                </div>
                <input type="text" id="checkcode" name="checkcode" class="input" placeholder="请输入验证码">
                <?php 
	            	if (isset($_GET['err_code'])) {
	            		echo '<p class="error">'.urldecode($_GET['err_code']).'</p>';
	            	}
	            ?>
            </div>
            <div class="submitbtn">
                <button type="submit" id="subForm" style="">注册</button>
            </div>
        </form>
        <div class="footer">
            <p><?php echo WEBSITE_NAME;?></p>
        </div>
    </div>
</body>
</html>
