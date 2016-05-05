<?php
	require('./init.php');	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
		<link rel="stylesheet" type="text/css" href="../css/style.css"/>
		<style>
			.container table tr{
				height: 40px;
			}
		</style>
	</head>
	<body class="bg">
		<div style="width: 40%;margin: 30px auto;" class="container">
			<h2 align="center">修改密码</h2>
			<center style="margin-top: 40px;color: red;">
			<?php 
				if(!empty($_POST)){
					if(isset($_POST['password'])){
						if(md5($_POST['password']) == $_SESSION['password']){
							if($_POST['newpass'] == $_POST['confirmnewpass']){
								$newpass = md5($_POST['newpass']);
								$sql = "update admin_user set password='{$newpass}' where user_name='{$_SESSION['user_name']}'";
								mysql_query($sql);
								if(mysql_affected_rows()>0){
									echo "<script language='javascript'>alert('密码修改成功');parent.location='../index.php';</script>";
									$_SESSION['password'] = $newpass;
									exit;
								}else{
									echo "密码修改失败";
								}
							}else{
								echo "新密码和确认新密码不一致";
							}
						}else{
							echo "原密码错误";
						}
					}
				}
			 ?>
			</center>
			<form method="post" action="editpassword.php" id="editpassform">
				<table border="0px" align="center">
					<tr>
						<td><label for="password">原密码</label></td>
						<td><input type="password" name="password" /></td>
					</tr>
					<tr>
						<td><label for="newpass"></label>新密码</label></td>
						<td><input type="password" name="newpass" /></td>
					</tr>
					<tr>
						<td><label for="confirmnewpass">确认新密码</label></td>
						<td><input type="password" name="confirmnewpass" /></td>
					</tr>
					<tr><td colspan="2" align="center">
					<input type="submit" value="确认修改" /></td></tr>
				</table>
			</form>
		</div>
	</body>
</html>
