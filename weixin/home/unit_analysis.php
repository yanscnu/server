<?php
	require_once('./Control/MemberControl.php');
	if(isLogin() == false){
		toLoginPage();
	}
	//引入用户分析类
	require ROOT_PATH.'lib/UserAnalysis.class.php';
	
	$student_id = $_SESSION['student_id'];
	
	$query = "SELECT `unit_id`,`answer_time` FROM `practice_record` pr INNER JOIN `practice` p
	               WHERE `student_id`={$student_id} AND pr.`pid`=p.`pid` ORDER BY `answer_time`";
	$result = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($result) <= 0) {
	    show_message('你还没完成学习', true);
	}
	/*
	 * 单元学习路径
	 */
	$answer_time_arr = array();
	while ($row = mysql_fetch_assoc($result)) {
	    $answer_time_arr[] = $row;
	}
	$userAnalysis = new UserAnalysis($student_id);
	$learn_path_data = $userAnalysis->createUintLearnPathData($answer_time_arr);
    
	/*
	 * 学习成绩
	 */
	$learn_grade_data = $userAnalysis->createLearnGradeData();
	

?>

<!doctype html>
<html lang="en">
<head>
    <title>学习反馈报告</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
  <script type="text/javascript" src="<?php echo __ROOT__;?>include/js/jquery-1.8.3.min.js"></script>
  <script type="text/javascript" src="<?php echo __ROOT__;?>include/js/Highcharts-4.1.9/highcharts.js"></script>
  <script type="text/javascript" src="<?php echo __ROOT__;?>include/js/Highcharts-4.1.9/modules/exporting.js"></script>	
  <script type="text/javascript" src="<?php echo __ROOT__;?>home/js/unit_analysis.js"></script>
  <script type="text/javascript">
		var project_root = "<?php echo __ROOT__;?>";
		//在线时间差
		var online_time_cha = <?php echo ONLINE_TIME;?>;
		var learn_path_data = <?php echo json_encode($learn_path_data); ?>;
		var learn_grade_data = <?php echo json_encode($learn_grade_data); ?>;
		$(function() {
			$('#unit_list dl dd').hide();
			$('#unit_list dl dt').click(function() {
				$(this).parent().find('dd').slideToggle();
			});
		});
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
	   dl{
	   	   max-width: 100px;
	   	   margin: 0 auto;
	   }
	   dl dt{
	   	   height: 24px;
	   	   line-height: 24px;
	   	   background: #999;
	   	   cursor:pointer;
	   	   color:#FFF;
	   }
	   dl dd{
	   	   margin: 0;
	   	   padding: 0;
	   	   height: 24px;
	   	   line-height: 24px;
	   	   background: #79CAFF;
	   	   border-bottom: 1px solid #FFF;
	   	/*超出部分以省略号代替*/
	   	   white-space:nowrap;
	   	   overflow:hidden; 
	   	   text-overflow:ellipsis;
	   }
	   dl dd a{
	   	   text-decoration: none;
	   	   color: black;
	   	
	   }
	</style>
</head>
<body>
  <div id="learn_path" style="width: 100%;"></div>
  <div id="unit_list" style="text-align: center;padding-bottom: 20px;">
    <dl>
        <dt>课时学习路径</dt>
        <?php
            $units = getUnitList();
            foreach ($units as $key=>$value) {
                if (isLearnUnit($student_id, $key)) {
                    echo "<dd><a href='curriculum_learn_path.php?unit_id={$key}'>{$value}</a></dd>";
                };
            }
        ?>
    </dl>
  </div>
  <hr>
  <div id="learn_grade" style="width: 100%;"></div>
  <div id="style_report" style="text-align: center;padding-bottom: 20px;">
    <dl>
        <dt><a href='style_report.php' style="color: #FFF;text-decoration: none;">学习风格报告</a></dt>
    </dl>
  </div>
</body>
</html>