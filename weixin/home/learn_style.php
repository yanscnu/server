<?php
	require_once('./Control/MemberControl.php');
	if(isLogin() == false){
		toLoginPage();
	}
	//引入用户分析类
	require ROOT_PATH.'lib/UserAnalysis.class.php';
	$student_id = $_SESSION['student_id'];
	
	//学习风格
	$style = array();
	
	/**
	 * 学习资源利用
	 * （比较各个资源浏览的次数来决定，浏览次数最高）
	 * 书面文字型、直观形象型、声音理解型
	 * 
	 */
	
	$query = "SELECT ai.`art_type`, SUM(`read_count`) read_sum FROM `read_behavior` rb INNER JOIN `article_info` ai 
	           where rb.`art_id`=ai.`art_id` GROUP BY ai.`art_type`";
	$result = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($result) <= 0) {
	    show_message('没有记录', true);
	}
	$art_types_count = array();
	while (($row = mysql_fetch_assoc($result)) != false) {
	    $art_types_count[$row['art_type']] = $row['read_sum'];
	}
	
	$max_art_tye = array_keys($art_types_count, max($art_types_count));
	switch ($max_art_tye[0]) {
	    case 1:
	       $style['resource'] = '书面文字型';
	       break;
       case 2:
           $style['resource'] = '直观形象型';
           break;
       case 3:
           $style['resource'] = '声音理解型';
           break;
	}
	
	$curriculum_count = getCourseCount('curriculum');
	$unit_count = getCourseCount('unit');
	
	/**
	 * 参与讨论的次数
	 */
	$query = "SELECT COUNT(*) `discuss_count` FROM `discuss` WHERE `student_id`={$student_id} AND `father_id`=0";
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_assoc($result);
	$discuss_count = $row['discuss_count'];
	if ($discuss_count > $curriculum_count) {
	    $style['interaction'] = '积极参与型';
	} else if ($discuss_count < ($curriculum_count/2)) {
	    $style['interaction'] = '逃避型';
	} else {
	    $style['interaction'] = '观望型';
	}
?>

<!doctype html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
  <script type="text/javascript" src="<?php echo __ROOT__;?>include/js/jquery-1.8.3.min.js"></script>
  <script type="text/javascript" src="<?php echo __ROOT__;?>include/js/Highcharts-4.1.9/highcharts.js"></script>
  <script type="text/javascript">
		var project_root = "<?php echo __ROOT__;?>";
		//在线时间差
		var online_time_cha = <?php echo ONLINE_TIME;?>;
	</script>
	<style type="text/css">
	   p{
	   	   font-size:16px;
	   	   line-height:26px;
	   	   text-indent: 32px;
	   }
	</style>
</head>
<body>
    <div id="container" style="width: 100%;">
        <p>前言</p>
        
        <p>在学习资源利用方面，你是：<span style="color: blue;"><?php echo $style['resource'];?></span>，blablabla描述下</p>
        
        <p>在交互学习的过程中，你属于：<span style="color: blue;"><?php echo $style['interaction'];?></span>，blablabla描述下</p>
        
        <p>Doers团队针对此次学习分析给你的反馈建议是：******（针对交互学习中积极的）；*******（针对*****中*****）；</p>
        
        <p>本建议仅供参考，希望本次学习反馈对你的知识巩固有一定的帮助与提升。再次感谢你对本团队的关注与支持！</p>
    </div>
</body>
</html>