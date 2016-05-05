<?php
	require('../common/init.php');
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel="stylesheet" type="text/css" href="../css/basic.css"/>
	<script src="../../include/js/jquery-1.5.2.min.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>文章管理</title>
</head>

<body class="bg">

<?php include ROOT_PATH.'weiadmin/common/content-header.html';?>

<center style="margin-top: 50px;font-size: 50px;">	
<?php
	$action = isset($_GET['act'])?$_GET['act']:null;
	if($action != null){
		if(function_exists($action)){
			$action();
		}else{
			exit('异常访问！参数有误！');
		}
	}else{
	}
	
	/**
	 * 习题添加
	 */
	function practice_add() {
		$unit_id = $_POST['unit_id'];
		$practice_content = $_POST['content'];
		$sql = "INSERT INTO `practice`(`unit_id`,`practice_content`) VALUES({$unit_id},'{$practice_content}')";
		mysql_query($sql) or die(mysql_error());
		if (mysql_affected_rows()) {
			echo '习题添加成功！';
		}
	}
	
	function practice_mod() {
		$pid = $_POST['pid'];
		$unit_id = $_POST['unit_id'];
		$practice_content = $_POST['content'];
		$sql = "UPDATE `practice` SET `unit_id`={$unit_id},`practice_content`='{$practice_content}' WHERE `pid`={$pid}";
		mysql_query($sql) or die(mysql_error());
		echo '习题修改成功！';
	}
	
	/**
	 * 删除习题
	 */
	function practice_del() {
		$pid = $_GET['pid'];
		$sql = "DELETE FROM `practice` WHERE `pid`={$pid}";
		mysql_query($sql) or die(mysql_error());
		if (mysql_affected_rows() > 0) {
			echo '删除成功';
		} else {
			echo '删除失败';
		}
	}
	
	/**
	 * 习题答案添加
	 */
	function answer_add(){
		$post_str = serialize($_POST);
		$pid = $_GET['pid'];
		$sql = "UPDATE `practice` SET `answer_content`='{$post_str}' WHERE `pid`={$pid}";
		mysql_query($sql) or die($sql);
		if(mysql_affected_rows()>0){
			echo '答案添加成功';
		}else {
			echo '答案添加失败';
		}
	}
	
	/**
	 * 习题答案修改
	 */
	function answer_mod(){
		$post_str = serialize($_POST);
		$pid = $_GET['pid'];
		$sql = "UPDATE `practice` SET `answer_content`='{$post_str}' WHERE `pid`={$pid}";
		mysql_query($sql) or die($sql);
		if(mysql_affected_rows()>0){
			echo '答案修改成功';
		}else {
			echo '答案没有改动';
		}
	}
?>
	</center>
</body>
</html>
