<?php
	if (!session_id()) {
		session_start();
	}
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

/*
 * 修改：yan
 * 已修改为session来保存用户信息
 */ 
if($_REQUEST['act']=='exit'){
	 unset($_SESSION['password']);
	 unset($_SESSION['user_name']);
	 echo "<script language='javascript'>parent.location = '../login.php';</script>";
}

?>