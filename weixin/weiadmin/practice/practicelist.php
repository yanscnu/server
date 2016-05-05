<?php 
	require('../common/init.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel="stylesheet" type="text/css" href="../css/basic.css"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>习题列表</title>
	<style type="text/css">
		.practicelist{
			text-align: center;
		}
	</style>
</head>

<body class="bg">

<?php include ROOT_PATH.'weiadmin/common/content-header.html';?>

<div class="container">
	<div class="practicelist">
		<h2>习题列表</h2>
		<table class="table" cellpadding="0" cellspacing="0">
			<tr>
			    <th>习题编号</th>
			    <th>所属单元</th>
			    <th>操作</th>
			</tr>
			<?php
				$sql="SELECT `pid`,`art_class_name` FROM `practice` p INNER JOIN `art_class` ac 
						where p.`unit_id`=ac.`art_class_id`";
				$result = mysql_query($sql) or die(mysql_error());
				
				while($row = mysql_fetch_assoc($result)){
					echo '<tr>';
					echo '<td>'.$row['pid']."</td>";
					echo '<td>'.$row['art_class_name'].'</td>';
					
					$sql = "SELECT COUNT(*) count FROM `practice` WHERE `pid`={$row['pid']} AND `answer_content`!=''";
					$result_count = mysql_query($sql) or die(mysql_error());
					$row_count = mysql_fetch_assoc($result_count);
					
					echo '<td>';
						echo "<a id='del' href='practicedetail.php?pid={$row['pid']}'>查看详细</a>";
						if ($row_count['count'] <= 0) {
							echo " | <a id='del' href='answeradd.php?pid={$row['pid']}'>添加答案</a>";
						} 
// 						else {
// 							echo " | <a id='del' href='answerdetail.php?pid={$row['pid']}'>查看答案</a>";
// 						}
						echo " | <a href='practiceaction.php?act=practice_del&pid={$row['pid']}' 
									onclick='return delConfirm(\"{$row['art_class_name']}\");'>删除</a>";
					echo '</td>';
					echo "</tr>";
				}
			?>
		</table>
	</div>
</div>
	<script type="text/javascript">
		function delConfirm(name){
			return confirm("确定要删除单元《"+name+"》的习题吗？");
		}
	</script>
</body>
</html>