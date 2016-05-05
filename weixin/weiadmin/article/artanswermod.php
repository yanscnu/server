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
	
	/**
	 * 从数据库中查询出之前的答案
	 */
	$sql = "select `answer_content` from `practice_answer` 
			where `art_id`={$_GET['art_id']}";
	$result_pa = mysql_query($sql); 
	$row_pa = mysql_fetch_assoc($result_pa);
?>
<!DOCTYPE html>
<html>
<head>
	<title>修改标准答案</title>
	<link rel="stylesheet" type="text/css" href="../css/basic.css"/>
	<script src="../../include/js/jquery-1.5.2.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
		var answer_content = <?php echo json_encode(unserialize($row_pa['answer_content'])); ?>;
		for(var key in answer_content){  
			if(answer_content[key] instanceof Array){
		   		var inputs = $("input[name='"+key+"[]']");
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
		   		var inputs = $("input[name='"+key+"']");
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

<div class="container">
	<h1 style="text-align: center;">添加标准答案</h1>
	<form id="art_form" action="artaction.php?act=art_answer_mod&art_id=<?php echo $art_id; ?>" method="post" enctype="multipart/form-data">
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
