<?php 
	require('../common/init.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../css/basic.css"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<title>分类管理</title>
</head>

<body class="bg">

<div class="clear"></div>

<center style="font-size: xx-large;margin: 20px;">
	
<?php
	if(isset($_GET['action'])){
		switch ($_GET['action']) {
			case 'add':
			{
				//获取要添加的信息
				$art_class_name = $_POST['art_class_name'];
				$fid = $_POST['fid'];
				$path = $_POST['path'];
				$art_class_sort = $_POST['art_class_sort'];
				$art_class_brief = $_POST['art_class_brief'];
				$art_class_goal = $_POST['art_class_goal'];
				$sql = "insert into art_class(art_class_name,art_class_sort,art_class_brief,
												art_class_goal,art_class_father_id,path) 
							values('{$art_class_name}',{$art_class_sort},'{$art_class_brief}','{$art_class_goal}',{$fid},'{$path}')";
				mysql_query($sql) or die(mysql_error());
				if(mysql_affected_rows()>0){
					echo "添加成功";
				}else {
					echo "添加失败";
				}
				break;
			}
			case 'mod':{
				$art_class_id = $_POST['art_class_id'];
				$art_class_sort = $_POST['art_class_sort'];
				$art_class_name = $_POST['art_class_name'];
				$art_class_brief = $_POST['art_class_brief'];
				$art_class_goal = $_POST['art_class_goal'];
				$sql = "UPDATE `art_class` SET `art_class_sort`={$art_class_sort}, `art_class_name`='{$art_class_name}',
							`art_class_brief`='{$art_class_brief}',`art_class_goal`='{$art_class_goal}' WHERE `art_class_id`={$art_class_id}";
				mysql_query($sql) or die(mysql_error().'2222');
				echo '修改成功！';
				break;
			}
			case 'del':
			{
				//获取id号，拼装sql语句
				$id = $_GET['id'];
				//执行删除
				
				//查询该分类下的子分类的id(包括该分类)
// 				$sql = "select art_class_id from art_class where art_class_id={$id} or path like '%,{$id},%'";
// 				$result = mysql_query($sql);
// 				$classid_array = array();
// 				while ($row = mysql_fetch_assoc($result)) {
// 					$classid_array[] = $row['art_class_id'];
// 				}
// 				$whr = implode(",", $classid_array);
// 				//删除该分类及其子分类
// 				$sql = "delete from art_class where art_class_id in ({$whr})";
// 				mysql_query($sql);
// 				$count1 = mysql_affected_rows();
// 				/*
// 				 * 删除该分类及其子分类下的数据
// 				 */
// 				$sql = "delete from article_info where art_class_id in ({$whr})";
// 				mysql_query($sql);
// 				$count2 = mysql_affected_rows();
// 				echo "成功删除: {$count1}个分类 , {$count2}篇文章！<br/>";

				$sql = "select count(*) `son_sum` from `art_class` where `art_class_father_id`={$id}";
				$result = mysql_query($sql);
				$row = mysql_fetch_assoc($result);
				if ($row['son_sum'] > 0) {
					echo('分类下有子分类，不能删除');
					break;
				}
				
				$sql = "select count(*) `art_sum` from `article_info` where `art_class_id`={$id}";
				$result = mysql_query($sql);
				$row = mysql_fetch_assoc($result);
				if ($row['art_sum'] > 0) {
					echo('分类下有有文章，不能删除');
					break;
				}
				//满足条件，进行删除
				$sql = "delete from `art_class` where `art_class_id`={$id}";
				mysql_query($sql);
				if (mysql_affected_rows()) {
					echo "分类删除失败";
				} else {
					echo "分类删除成功";
				}
				break;
			}
			default:
				break;
		}
	}
?>

</center>
<center style="margin: 10px;font-size: large;"><a href='classlist.php'>浏览分类信息</a>
</center>
</body>
</html>