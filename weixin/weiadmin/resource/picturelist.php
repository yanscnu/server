<?php
    require('../common/init.php');
    require (INCLUDE_PATH.'php/page.class.php');
    
    
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel="stylesheet" type="text/css" href="../css/basic.css"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>图片资源</title>
	<style type="text/css">
       .table tr td{
       	height: 80px;
       }
    </style>
</head>

<body class="bg">

<?php include ROOT_PATH.'weiadmin/common/content-header.html';?>

<div class="container">
	<center>
	   <h2>资源列表</h2>
	</center>
	<table class="table" cellpadding="0" cellspacing="0">
		<tr>
		  <td>
		      <img src="" alt="图片加载失败"/>
		  </td>
		  <td>
		      <span style="display:inline-block;padding: 5px 0;">名称：</span><br/>
		      <span style="display:inline-block;padding: 5px 0;">大小：</span>
	      </td>
		  <td>
		  获取链接&nbsp;删除
		  </td>
		</tr>
	</table>
</div>
	
	
	<script type="text/javascript">
		function delConfirm(name){
			return confirm("此操作将删除《"+name+"》分类及其子分类下的所有数据，确定删除吗？");
		}
	</script>
</body>
</html>
