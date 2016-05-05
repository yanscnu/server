<?php 
	require('../common/init.php');
	if (isset($_GET['art_class_id']) && $_GET['art_class_id'] == '') {
		exit('异常访问');
	}
	$art_class = artClassInfo($_GET['art_class_id']);
	if ($art_class == false) {
		exit('异常访问');
	}
?>
<!DOCTYPE html>
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
		<form action="classaction.php?action=mod" method="post">
			<input type="hidden" name="art_class_id" value="<?php echo $_GET['art_class_id'];?>"/>
			<table class="table classadd-table" cellpadding="0" cellspacing="0">
				<tr >
					<td>类别名称：</td>
					<td><input type="text" name="art_class_name" value="<?php echo $art_class['art_class_name'];?>"/></td>
				</tr>
				<tr>
					<td >分类排序：</td>
					<td><input type="text" name="art_class_sort" value="<?php echo $art_class['art_class_sort'];?>"/></td>
				</tr>
				<tr >
					<td >类别简介：</td>
					<td>
						<textarea  name="art_class_brief"><?php echo $art_class['art_class_brief'];?></textarea>
					</td>
				</tr>
				<tr >
					<td >课程目标：</td>
					<td>
						<textarea  name="art_class_goal"><?php echo $art_class['art_class_goal'];?></textarea>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" class="button" value="修改" onclick="return confirm('确定要修改吗？');"/>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
	</body>
</!DOCTYPE>