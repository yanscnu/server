<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Doers微信学习平台登录</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="../include/css/animate.css">
	<link rel="stylesheet" type="text/css" href="./css/basic.css" />
	<link rel="stylesheet" type="text/css" href="./css/login.css" />
	<script src="../include/js/jquery-1.5.2.min.js"></script>
	<script src="../include/js/md5-min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="./js/login.js"></script>
</head>

<body class="login">
	<div class="pulse animated loginbox">
		<h1>Doers微信学习平台登录</h1>
		<form name="login" id="loginForm" action="./common/init.php" method="post">
			<ul>
				<li><span>账号</span><input type="text" name="username"/></li>
				<li><span>密码</span><input type="password" name="password"/></li>
				<li style="margin: 30px 0px 0px 76px;">
					<button type="submit">登陆</button>
					<button type="reset">重置</button>
				</li>
			</ul>
			<input type="hidden" name="act" value="signin"/>
		</form>
	</div>
	<div class="loginfooter flipInX animated">
		<p>Make by Doers.</p>
	</div>
</body>
</html>