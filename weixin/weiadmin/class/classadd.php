<?php 
require('../common/init.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>分类添加</title>
	<meta charset="UTF-8"/>
	<link rel="stylesheet" type="text/css" href="../css/basic.css"/>
	<link rel="stylesheet" type="text/css" href="../css/class.css"/>
</head>
<body class="bg">

<?php include ROOT_PATH.'weiadmin/common/content-header.html';?>

<div class="container">
	<div class="classadd">
		<h2>分类添加</h2>
		<form action="classaction.php?action=add" method="post">
			<input type="hidden" name="fid" value="<?php echo isset($_GET['fid'])?$_GET['fid']:0 ?>" />
			<input type="hidden" name="path" value="<?php echo isset($_GET['path'])?$_GET['path']:'0,' ?>" />
			<table class="table classadd-table" cellpadding="0" cellspacing="0">
				<tr >
					<td>父类别：</td>
					<td><?php echo isset($_GET['fname'])?$_GET['fname']:"根类别" ?></td>
				</tr>
				<tr >
					<td>类别名称：</td>
					<td><input type="text" name="art_class_name" autofocus/></td>
				</tr>
				<tr>
					<td >分类排序：</td>
					<td><input type="text" name="art_class_sort"/></td>
				</tr>
				<tr >
					<td >类别简介：</td>
					<td>
						<textarea  name="art_class_brief"></textarea>
					</td>
				</tr>
				<tr >
					<td >课程目标：</td>
					<td>
						<textarea  name="art_class_goal"></textarea>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" class="button" value="添加"/>&nbsp;&nbsp;&nbsp;
						<input type="reset" class="button" value="重置"/>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
	</body>
</html>