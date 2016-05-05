<?php
	require '../common/init.php';
	$art_id = $_GET['art_id'];
	$art_class_id = $_GET['art_class_id'];
	$sql = "select * from article_info where art_id={$art_id}";
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	$sql = "select art_class_name from art_class where art_class_id={$art_class_id}";
	$result_class = mysql_query($sql);
	$row_class = mysql_fetch_assoc($result_class);
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<script src="../../include/js/jquery-1.5.2.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/basic.css"/>
	<style type="text/css">
		.artview{
			width: 70%;margin: 10px auto;
		}
		.artview .artview-table tr td:first-child{
			border-right: 1px solid #DDDDDD;
		}
		.header-center{
			width:80%;
			padding:0 10%;
			text-align: left;
		}
		.header-center ul li{
			display: inline-block;
		}
		.header-center ul li a{
			display: inline-block;
			width: 80px;
			height: 40px;
			line-height: 40px;
			text-align: center;
		}
		.header-center ul li a:HOVER{
			background-color: #0099FF;
		}
	</style>
</head>
<body class="bg">

<?php include ROOT_PATH.'weiadmin/common/content-header.html';?>
	<div class="header-center">
		<ul>
			<li><a href="artmod.php?art_id=<?php echo $row['art_id'] ?>">修改文章</a></li>
		</ul>
	</div>

	<div class="artview" id="view">
		<h2 align="center">查看文章</h2>
		<table class="table artview-table" cellpadding="0" cellspacing="0">
			<tr>
				<td>文章编号</td>
				<td><?php echo $row['art_id'];?></td>
			</tr>
			<tr>
				<td>文章标题</td>
				<td><?php echo $row['art_title'];?></td>
			</tr>
			<tr>
				<td>作者</td>
				<td><?php echo $row['author'];?></td>
			</tr>
			<tr>
				<td>排序</td>
				<td><?php echo $row['art_sort'];?></td>
			</tr>
			<tr>
				<td>发表时间</td>
				<td><?php echo $row['publication_time'];?></td>
			</tr>
			<tr>
				<td>类别</td>
				<td><?php echo $row_class['art_class_name'];?></td>
			</tr>
			<tr>
				<td>类型</td>
				<td>
					<?php
						$type = '';
						switch ($row['art_type']) {
							case '1':
								$type = '文字';
								break;
							case '2':
								$type = '图文';
								break;
							case '3':
								$type = '视频';
								break;
						}
						echo $type;
					?>
				</td>
			</tr>
			<tr>
				<td>状态</td>
				<td>
					<?php 
						$state = '';
						switch ($row['state']) {
							case '0':
								$state = '草稿';
								break;
							case '1':
								$state = '发布';
								break;
							case '2':
								$state = '回收站';
								break;
						}
						echo $state;
					?>
				</td>
			</tr>
			<tr>
				<td>字数</td>
				<td><?php echo $row['words_num'];?></td>
			</tr>
			<tr>
				<td>简介</td>
				<td><?php echo $row['brief'];?></td>
			</tr>
			<tr>
				<td>缩略图</td>
				<td>
					<?php 
						if ($row['thumbnail'] == '') {
							echo '<del>没有缩略图</del>';
						} else {
							echo "<img style='width:100px;' src='<?php echo __THUMBNAIL__.{$row['thumbnail']};?>'/>";
						}
					?>
				</td>
			</tr>
		</table>
		<br/>
		<div>
			<?php echo $row['text'];?>
		</div>
</div>
</body>
</html>
