<?php
	if (!session_id()) {
		session_start();
	}
	$document_root = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']),'/');
	require_once($document_root.'/weixin/config/init.php');
	
	
  //act初始化
  if (!isset($_REQUEST['act']))
  {
	  $_REQUEST['act'] = '';
  }
  
  if (empty($_REQUEST['act']))
  {
	  $_REQUEST['act'] = 'login';
  }
  else
  {
	  $_REQUEST['act'] = trim($_REQUEST['act']);
  }
  
  //检查登陆
  if($_REQUEST['act']=='signin')
  {
	  $_POST['username'] = isset($_POST['username']) ? trim($_POST['username']) : '';
	  $_POST['password'] = isset($_POST['password']) ? trim($_POST['password']) : '';
	  $result = mysql_query("SELECT `user_name`,`password` FROM admin_user where `user_name`='{$_POST['username']}'");
  		$row = mysql_fetch_assoc($result);
		  if($row['user_name']==$_POST['username'] && $row['password']==$_POST['password']){
//			setcookie('user_name',$row['user_name'],time()+3600);
//			setcookie('password',$row['password'],time()+3600);
			/*
			 * 修改cookie为session
			 */
					$_SESSION['user_name'] = $row['user_name'];
					$_SESSION['password'] = $row['password'];
					header("Location:/weixin/weiadmin/index.php");
					exit;
		  }
		  else{
			  echo "<script language='javascript'>alert('用户名或密码错误！');history.back();</script>";
			  exit;
			}
  }
   
  //验证是否已经登陆
  if(!isset($_SESSION['user_name']))	//修改cookie为session
  {
	echo "<script language='javascript'>document.location='/weixin/weiadmin/login.php';</script>";	
	exit;
  }
  else{
	$result = mysql_query("SELECT `password` FROM admin_user where `user_name`='{$_SESSION['user_name']}'") or die(mysql_error());
	if (mysql_num_rows($result) <= 0) {
	    exit('异常访问');
	}
	$row = mysql_fetch_assoc($result);
	if($row['password']!=$_SESSION['password']){	//修改cookie为session
		echo "<script language='javascript'>document.location = '/weixin/weiadmin/login.php';</script>";	
		exit;
	}
  } 
  ?>