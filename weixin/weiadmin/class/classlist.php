<?php
	require('../common/init.php');
	
	$fid = isset($_GET['fid']) ? $_GET['fid']:0;
	$typeres = null;
	if($fid>0){
		//根据当前类别获取
		$sql = "select path from art_class where art_class_id={$fid}";
		$res = mysql_query($sql);
		$path= mysql_result($res, 0,0);
		
		//获取当前位置上的所有路径类别信息列表
		$sql = "select art_class_id,art_class_name from art_class where art_class_id 
					in ({$path}{$fid}) order by art_class_id";
		$typeres = mysql_query($sql);
	}
?>
<!--
	作者：1091780277@qq.com
	时间：2015-11-03
	描述：分类管理页面，即显示分类的页面
-->



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel="stylesheet" type="text/css" href="../css/basic.css"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>分类列表</title>
	<script type="text/javascript">
		function delConfirm(name){
			return confirm("此操作将删除《"+name+"》分类及其子分类下的所有数据，确定删除吗？");
		}
	</script>
</head>

<body class="bg">

<?php include ROOT_PATH.'weiadmin/common/content-header.html';?>

<div class="container">
	<center>
	<h2>分层分类列表</h2>
	<div style="width: 600px;text-align: left;">
		当前位置: <a href="classlist.php">根类别</a>&nbsp;&gt;&gt;
		<?php  
			//判断并遍历输出路径信息
			if($typeres && mysql_num_rows($typeres)>0){
				while ($row = mysql_fetch_assoc($typeres)) {
					 echo "<a href='classlist.php?fid={$row['art_class_id']}'>{$row['art_class_name']}</a>&nbsp;&gt;&gt";
				}
			}
		?>
	</div>
	</center>
	<table class="table" cellpadding="0" cellspacing="0">
		<tr>
		    <th>类别编号</th>
		    <th>类别名称</th>
		    <th>类别简介</th>
		    <th>操作</th>
		</tr>
		<?php
			$sql="select * from art_class where art_class_father_id={$fid}";
			$result=mysql_query($sql);
			$row_array=array();
			while($row = mysql_fetch_assoc($result)){
				echo "<tr>";
				echo "<td>".$row['art_class_id']."</td>";
				echo "<td><a href='classlist.php?fid={$row['art_class_id']}'>".$row['art_class_name']."</a></td>";
				echo "<td>".$row['art_class_brief']."</td>";
				echo "<td><a id='del' href='classadd.php?fid={$row['art_class_id']}&fname={$row['art_class_name']}&path={$row['path']}{$row['art_class_id']},'>添加子分类</a>".
							"| <a href='classmod.php?art_class_id={$row['art_class_id']}'>修改</a>".
							"| <a href='classaction.php?action=del&id={$row['art_class_id']}' 
								onclick='return delConfirm(\"{$row['art_class_name']}\");'>删除</a></td>";
				echo "</tr>";
			}
		?>
	</table>
</div>
	
	
	<script type="text/javascript">
		function delConfirm(name){
			return confirm("此操作将删除《"+name+"》分类及其子分类下的所有数据，确定删除吗？");
		}
	</script>
</body>
</html>
