<?php
	require_once('./Control/MemberControl.php');
	if(isLogin() == false){
		toLoginPage();
	}
	//引入用户分析类
	require ROOT_PATH.'lib/UserAnalysis.class.php';
	
	$student_id = $_SESSION['student_id'];
	
	$query = "SELECT `unit_id`,`answer_time` FROM `practice_record` pr INNER JOIN `practice` p
	               WHERE `student_id`={$student_id} AND pr.`pid`=p.`pid` ORDER BY `answer_time` LIMIT 3";
	$result = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($result) <= 0) {
	    show_message('你还没完成学习', true);
	}
	
	/*
	 * 学习风格
	 */
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
    <title>学习风格报告书</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
  <script type="text/javascript" src="<?php echo __ROOT__;?>include/js/jquery-1.8.3.min.js"></script>
  <script type="text/javascript" src="<?php echo __ROOT__;?>include/js/Highcharts-4.1.9/highcharts.js"></script>
  <script type="text/javascript" src="<?php echo __ROOT__;?>include/js/Highcharts-4.1.9/modules/exporting.js"></script>	
  <script type="text/javascript">
		var project_root = "<?php echo __ROOT__;?>";
		//在线时间差
		var online_time_cha = <?php echo ONLINE_TIME;?>;
	</script>
	<style type="text/css">
        body{
        	font-family: '微软雅黑';
        }
	   p{
	   	   font-size:16px;
	   	   line-height:26px;
	   	   text-indent: 32px;
	   }
	   div{
	   	   margin-top: 30px;
	   }
	   #learn_style h3{
	   	   text-align: center;
	   }
       #learn_style hr{
	   	margin: 5px 0;
	   	border: 1px solid #578EC3;
	   }
	   #learn_style .foot p{
	   	   font-size: 12px;
	   	   text-indent: 24px;
	   	   line-height: 20px;
	   }
	</style>
</head>
<body>
  <div id="learn_style" style="width: 100%;">
    <h3>学习风格报告书</h3>
    <hr><hr>
    <section style="color: #999;">
        <?php 
            $query = "SELECT `student_name` FROM `student` WHERE `student_id`={$student_id}";
            $result_student = mysql_query($query);
            $row_student = mysql_fetch_assoc($result_student);
        ?>
        <span><?php echo $row_student['student_name'];?>同学:</span><br/>
        <p>Doers学习平台的所提供的学习风格报告书是本项目团队研究学习反馈的初步成果，旨在给同学提供可视化反馈信息，帮助同学们对自身的学习情况有更多的认识并在此基础上获得提升！
        </p>
    </section>
    <hr>
    <section>
        <span>在学习资源利用方面，你是：</span>
        <p><span style="color: blue;">
                <?php 
//                     echo $style['resource'];
                       echo '直观形象型';
                ?>
            </span>，
                                希望在学习过程有许多图形图像和表格，这些形式的学习资源对你的学习效果有明显的正面影响。
        </p>
    </section>
    <hr>
    <section>
        <span>在交互学习的过程中，你属于：</span>
        <p><span style="color: blue;">
            <?php 
//                 echo $style['interaction'];
                    echo '积极型';
            ?>
            </span>，
                            喜欢参加集体学习活动，会主动提问并回答其他学习者的问题，在个人学习的过程中与他人有非常良好的互动。
        </p>
    </section>
    <hr>
    <section>
        <span>Doers团队针对此次学习分析给你的反馈建议是：</span>
    <p> 可以尝试更多元化的学习资源，在文字型较多的学习资源里用解构式的思路对文字块进行分解以达到更好的解读；
                         在学习中很积极与外界形成良好互动的同时，也要能沉下心思考学习问题，也可在这过程中引导较不活跃的同学参与互动。
    </p>
    </section>
    <hr>
    <section class="foot">
        <p>本建议仅供参考，希望本次学习反馈对你的知识巩固有一定的帮助与提升。再次感谢你对本团队的关注与支持！</p>
    </section>
    
  </div>
</body>
</html>