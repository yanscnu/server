<?php
	require_once('./Control/MemberControl.php');
	if(isLogin() == false){
		toLoginPage();
	}
	if(!isset($_GET['pid']) && !isset($_GET['pr_id'])){
		exit('异常访问！');
	}
	$pid = $_GET['pid'];
	
	$query = "SELECT `unit_id` FROM `practice` WHERE `pid`={$pid}";
	$result = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($result) <= 0) {
	    exit('异常访问');
	}
	$row = mysql_fetch_assoc($result);
	$unit_id = $row['unit_id'];
	$pr_id = $_GET['pr_id'];
	$student_id = $_SESSION['student_id'];
	$sql = "select `practice_content`,`art_class_name` from `practice` p INNER JOIN `art_class` ac where `pid`={$pid} 
	              AND p.`unit_id`=ac.`art_class_id`";
	$result = mysql_query($sql) or die(mysql_error());
	if (mysql_num_rows($result) <= 0) {
	    exit('异常访问');
	}
	$row = mysql_fetch_assoc($result);
	$practice_content = $row['practice_content'];
	$unit_name = $row['art_class_name'];
	
	$sql = "select `answer_result`,`record_content`,`correct_rate` from `practice_record` 
			where `pr_id`={$pr_id}";
	$result = mysql_query($sql) or die(mysql_error());
	if (mysql_num_rows($result) <= 0) {
	    exit('异常访问');
	}
	$row = mysql_fetch_assoc($result);
	$answer_result = $row['answer_result'];
	$record_content = $row['record_content'];
	$grade = (int)(doubleval($row['correct_rate'])*100);
?>


<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta charset="utf-8">
	<title>查看答题记录</title>
	<link rel="stylesheet" type="text/css" href="./css/basic.css" />
	<link rel="stylesheet" type="text/css" href="./css/practice.css" />
	<script src="../include/js/jquery-1.5.2.min.js"></script>
	<script src="./js/common.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="js/practiceresult.js"></script>
	<script>	
		var record_content = <?php echo json_encode(unserialize($record_content)); ?>;
		var answer_result = <?php echo json_encode(unserialize($answer_result)); ?>;
		var project_root = "<?php echo __ROOT__;?>";
		//在线时间差
		var online_time_cha = <?php echo ONLINE_TIME;?>;
	</script>
</head>
<body>
	<div class="header">
	<h2><?php echo WEBSITE_NAME;?></h2>
</div>
<!-- <div class="endbanner"> -->
<!-- 	<img src="img/endbanner.jpg" /> -->
<!-- </div> -->
<div class="evaluate">
	<div class="explain">
		<h4>《<?php echo $unit_name;?>》习题完成情况</h4>
		<div class="explaincon">
			<p>
			   <?php 
			     if ($grade > 90) {
			         echo '恭喜你，您获得了<span style="color:blue;">'.$grade.'</span>分，您对本单元的知识点掌握的<span style="color:green;">很不错</span>哟！继续努力，再接再厉！感谢你对本团队的关注与支持！';
			     } elseif ($grade > 75) {
			         echo '您获得了<span style="color:blue;">'.$grade.'</span>分，您对本单元的知识点掌握的<span style="color:green;">不错</span>哟！继续努力，再接再厉！感谢你对本团队的关注与支持！';
			     } elseif ($grade > 60) {
			         echo '您获得了<span style="color:blue;">'.$grade.'</span>分，您对本单元的知识点掌握的<span style="color:red;">一般</span>哟！继续努力，继续加油！感谢你对本团队的关注与支持！';
			     } else {
			         echo '您获得了<span style="color:blue;">'.$grade.'</span>分，您对本单元的知识点掌握的<span style="color:red;">很差</span>哟！建议重新学习知识点，再进行测试。感谢你对本团队的关注与支持！';
			     }
			   ?>
			</p>
		</div>
	</div>
	<div class="practice_content" >
	   <?php echo $practice_content?>
	</div>
</div>
<div class="evaluate" style="text-align: center;">
    <?php 
        $query = "SELECT COUNT(*) `count` FROM `evaluate_record` WHERE `student_id`={$student_id} AND `unit_id`={$unit_id}";
        $result = mysql_query($query) or die(mysql_error());
        $row = mysql_fetch_assoc($result);
        if ($row['count'] == 0) {
            echo "<a href='artend.php?unit_id={$unit_id}'>课程评价</a>";
        }
    ?>
</div>
</body>
</html>

