<?php
	require '../common/init.php';
	if (!isset($_GET['pid'])) {
		exit('非法访问');
	}
	$pid = $_GET['pid'];
	$sql = "SELECT `art_class_name`, `practice_content`,`answer_content` FROM `practice` p INNER JOIN `art_class` ac 
				where p.`unit_id`=ac.`art_class_id` AND `pid`={$pid}";
	$result = mysql_query($sql) or die(mysql_error());
	if (mysql_num_rows($result) <= 0) {
		exit('异常！！！');
	}
	$row = mysql_fetch_assoc($result);
?>


<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title></title>
	<script src="../../include/js/jquery-1.5.2.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/basic.css"/>
	<style type="text/css">
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
			width: 100px;
			height: 40px;
			line-height: 40px;
			text-align: center;
		}
		.header-center ul li a:HOVER{
			background-color: #0099FF;
		}
		.practicedetail{
			width: 70%;
			margin: 10px auto;
		}
		.practicedetail h2{
			text-align: center;
		}
		.practicedetail .practicedetail-table tr td:first-child{
			border-right: 1px solid #DDDDDD;
		}
		.practice-content{
			width:50%;
			margin: 0 auto;
		}
		.practice-content li{
			list-style: decimal;
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.practice-content input').attr('disabled', 'true');
			var answer_content = <?php echo json_encode(unserialize($row['answer_content'])); ?>;
			for(var key in answer_content){  
				   if(answer_content[key] instanceof Array){
				   		var inputs = $(".practice-content input[name='"+key+"[]']");
				   		var len = inputs.length;
				   		inputs.each(function(){
					   		if(isInArray($(this).val(), answer_content[key])){
					   			$(this).attr('checked' , 'true');
					   		}
					   	});
				   }else{
				   		/**
				   		 * 单选情况
				   		 */
				   		var inputs = $(".practice-content input[name='"+key+"']");
				   		var len = inputs.length;
				   		inputs.each(function(){
				   			if($(this).val() == answer_content[key]){
				   				$(this).attr('checked' , 'true');
				   			}
				   		});
				   } 
				}
		});
		function isInArray(value,arr){
			for(var key in arr){
				if(arr[key] == value){
					return true;
				}
			}
			return false;
		} 
	</script>
</head>
<body class="bg">

<?php include ROOT_PATH.'weiadmin/common/content-header.html';?>
	<div class="header-center">
		<ul>
			<li><a href="./practicemod.php?pid=<?php echo $pid;?>">修改习题</a></li>
			<?php 
				if ($row['answer_content'] == '') {
					echo "<li><a href='./answeradd.php?pid={$pid}'>添加习题答案</a></li>";
				} else {
					echo "<li><a href='./answermod.php?pid={$pid}'>修改习题答案</a></li>";
				}
			?>
		</ul>
	</div>

	<div class="practicedetail">
		<h2>查看习题</h2>
		<table class="table practicedetail-table" cellpadding="0" cellspacing="0">
			<tr>
				<td>习题编号</td>
				<td><?php echo $pid?></td>
			</tr>
			<tr>
				<td>所属单元</td>
				<td><?php echo $row['art_class_name'];?></td>
			</tr>
		</table>
		<br/>
		<div class="practice-content">
			<?php echo $row['practice_content']?>
		</div>
</div>
</body>
</html>