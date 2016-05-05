<?php
	require ('../common/init.php');
	if(!isset($_GET['art_id'])){
		exit('异常访问！！！');	
	}
	$art_id = $_GET['art_id'];
	/**
	 * 从数据库中查询出习题
	 */
	$sql = "select `text` from `article_info` where `art_id` = $art_id";
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
	<title>添加标准答案</title>
	<script src="../../include/js/jquery-1.5.2.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/basic.css"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body class="bg">

<?php include ROOT_PATH.'weiadmin/common/content-header.html';?>

<div class="container">
	<h1 style="text-align: center;">添加标准答案</h1>
	<form id="art_form" action="artaction.php?act=art_answer_add&art_id=<?php echo $art_id; ?>" method="post" enctype="multipart/form-data">
		<div class="artcontent" style="width:50%;margin: 30px auto;">
			<?php echo $row['text']; ?>
			<div class="">
				<input type="submit" value="提交" style="margin-top: 20px;" />
			</div>
		</div>
	</form>
</div>
</body>
</html>
