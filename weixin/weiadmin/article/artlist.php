<?php
	require ('../common/init.php');
	require (INCLUDE_PATH.'php/page.class.php');
?>
<?php
	$tmp = !empty($_POST) ? $_POST : $_GET;
	$whr = array();		//作为数据库查询的条件
	$args = "";			//作为分页对象的参数
	
	//如果bookname不为空，说明想搜索书名
	if(!empty($tmp['art_title'])) {
		$whr[] = "art_title like '%{$tmp['art_title']}%'";
		$args .= "&art_title={$tmp['art_title']}";
	}
	//如果author不为空，说明想搜索作者
	if(!empty($tmp['author'])) {
		$whr[] = "author like '%{$tmp['author']}%'";
		$args .= "&author={$tmp['author']}";
	}
	//如果brief不为空，说明想搜索简介
	if(!empty($tmp['brief'])) {
		$whr[] = "brief like '%{$tmp['brief']}%'";
		$args .= "&brief={$tmp['brief']}";
	}
	if(!empty($tmp['art_class_name'])) {
		$sql = "select art_class_id from art_class where art_class_name = '{$tmp['art_class_name']}'";
		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		if(isset($row['art_class_id'])){
			$sql = "select art_class_id from art_class where art_class_id={$row['art_class_id']} or path like '%,{$row['art_class_id']},%'";
			$result = mysql_query($sql);
			$classid_array = array();
			while ($row = mysql_fetch_assoc($result)) {
				$classid_array[] = $row['art_class_id'];
			}
			$id_whr = implode(",", $classid_array);
			$whr[] = "art_class_id in ({$id_whr})";
		}else {
			$whr[] = "art_class_id=0";		//使条件为假
		}
		$args .= "&art_class_name={$tmp['art_class_name']}";
	}
	
	if(!empty($whr)){
		$where = " where ".implode(" and ",$whr);	//作为数据库查询的条件
	}else {
		$where = "";
	}
	//echo "where:".$where."<br/>";
	//echo "args:".$args."<br/>";
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>文章列表</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="../css/basic.css"/>
		<link rel="stylesheet" type="text/css" href="../css/article.css"/>
		<script src="../../include/js/jquery-1.5.2.min.js"></script>
		<script type="text/javascript">
			function delConfirm(name) {
				return confirm("确定要删除文章《" + name + "》吗？");
			}
		</script>
	</head>
	<body class="bg">
	
	<?php include ROOT_PATH.'weiadmin/common/content-header.html';?>
	
		<div class="container">
			<div class="search">
				<form action="artlist.php" method="post">
					<label>标题：</label><input type="text" name="art_title" value="<?php echo isset($tmp['art_title'])?$tmp['art_title']:""; ?>"/>&nbsp;
					<label>作者：</label><input type="text" name="author" value="<?php echo isset($tmp['author'])?$tmp['author']:""; ?>"/>&nbsp;
					<label>简介：</label><input type="text" name="brief" value="<?php echo isset($tmp['brief'])?$tmp['brief']:""; ?>"/>&nbsp;
					<label>类别：</label><input type="text" name="art_class_name" value="<?php echo isset($tmp['art_class_name'])?$tmp['art_class_name']:""; ?>"/>&nbsp;
					<input type="submit" value="搜索"/>
				</form>
			</div>
			<table class="table" cellpadding="0" cellspacing="0">
			<tr>
				<!--<th>编号</th>-->
				<th>标题</th>
				<th>作者</th>
				<!--<th>简介</th>-->
				<!--<th>类别</th>-->
				<th>排序</th>
				<th>状态</th>
				<th>操作</th>
			</tr>
			<?php
				$sql = "select count(*) from article_info {$where}";
				$result = mysql_query($sql);
				$row = mysql_fetch_row($result);
				$count = $row[0]; 
				$page = new Page($count,15,$args);//传入参数记录总数、每页显示的记录数
				$limit = $page->limit;
				$sql = "select * from article_info {$where} order by art_class_id asc,art_sort asc {$limit}";
				$result = mysql_query($sql);
				while ($row = mysql_fetch_array($result)) {
					echo "<tr>";
					//	echo "<td>".$row['art_id']."</td>";
					echo "<td>" . $row['art_title'] . "</td>";
					echo "<td>" . $row['author'] . "</td>";
					//	echo "<td>".$row['brief']."</td>";
					//	echo "<td>".$row['art_class_id']."</td>";
					echo "<td>" . $row['art_sort'] . "</td>";
					switch ($row['state']) {
						case '0' :
							$state = "草稿";
							break;
						case '1' :
							$state = "发布";
							break;
						case '2' :
							$state = "回收站";
							break;
						default :
							$state = "";
							break;
					}
					echo "<td>" . $state . "</td>";
					echo "<td><a style='color:blue;' href='artview.php?art_id={$row['art_id']}&art_class_id={$row['art_class_id']}'>查看详细</a>" . 
							"|<a style='color:blue;' href='artmod.php?art_id={$row['art_id']}'>修改</a>" 
							. "|<a style='color:red;' onclick='return delConfirm(\"{$row['art_title']}\");' href='artaction.php?act=art_del&art_id={$row['art_id']}&page={$page->cpage}{$args}'>删除</a></td>";
					echo "</tr>";
				}
				echo "<tr><td colspan='5' align='right'>".$page->fpage(0,3,4,5,6)."</td></tr>";
			?>
		</table>
		</div>
	</body>
</html>
