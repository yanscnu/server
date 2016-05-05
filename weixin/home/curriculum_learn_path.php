<?php
	require_once('./Control/MemberControl.php');
	if(isLogin() == false){
		toLoginPage();
	}
	//引入用户分析类
	require ROOT_PATH.'lib/UserAnalysis.class.php';
	
	$student_id = $_SESSION['student_id'];
	if (!isset($_GET['unit_id'])) {
		exit('非法访问');
	}
	$unit_id = $_GET['unit_id'];
	//是否有
	$query = "SELECT `begin_time`,`learn_time` FROM `curriculum_learn` WHERE `student_id`={$student_id} 
				AND `unit_id`={$unit_id} ORDER BY `begin_time` DESC LIMIT 1";
	$result = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($result) <= 0) {
		show_message('该单元没有任何学习记录，不能生成学习路径！', true);
	}
// 	$row = mysql_fetch_assoc($result);
// 	$begin_time = $row['begin_time'];
// 	$learn_time = $row['learn_time'];
// 	$query = "SELECT `lp_id`,`last_time` FROM `learn_path` WHERE `student_id`={$student_id} AND `unit_id`={$unit_id}";
// 	$result = mysql_query($query) or die(mysql_error());
// 	//learn_path表有路径信息
// 	if (mysql_num_rows($result) > 0) {
// 		$row = mysql_fetch_assoc($result);
// 		//有新的学习数据，需要更新learn_path表的学习路径
// 		if ((strtotime($begin_time)+$learn_time)  > strtotime($row['last_time'])) {
// 			$userAnalysis = new UserAnalysis($student_id);
// 			$data_arr = $userAnalysis->createLearnPathData($unit_id);
// 			//更新路径到learn_path表中
// 			$learn_path_content = serialize($data_arr);
// 			$query = "UPDATE `learn_path` SET `learn_path_content`='{$learn_path_content}',
// 						`last_time`=NOW() WHERE `lp_id`={$row['lp_id']}";
// 			mysql_query($query) or die(mysql_error());
// 		} 
// 		//直接从learn_path表取出路径信息
// 		else {
// 			$query = "SELECT `learn_path_content` FROM `learn_path` WHERE `lp_id`={$row['lp_id']}";
// 			$result = mysql_query($query);
// 			$row = mysql_fetch_assoc($result);
// 			$data_arr = unserialize($row['learn_path_content']);
// 		}
// 	}
// 	//learn_path没有路径信息
// 	else {
// 		//生成学习路径
// 		$userAnalysis = new UserAnalysis($student_id);
// 		$data_arr = $userAnalysis->createLearnPathData($unit_id);
// 		//插入路径到learn_path表中
// 		$learn_path_content = serialize($data_arr);
// 		$query = "INSERT INTO `learn_path`(`student_id`, `type`,`unit_id`, `learn_path_content`, `last_time`) 
// 					VALUES({$student_id}, 1, {$unit_id}, '$learn_path_content', NOW())";
// 		mysql_query($query) or die(mysql_error());
// 	}

	/**
	 * 为方便起见，每次调用的时候都是直接生成，不进行判断（进行判断的情况见上面）
	 * @author yan
	 */
	$userAnalysis = new UserAnalysis($student_id);
	$data_arr = $userAnalysis->createLearnPathData($unit_id);
	

?>

<!doctype html>
<html lang="en">
<head>
    <title>学习路径</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
  <script type="text/javascript" src="<?php echo __ROOT__;?>include/js/jquery-1.8.3.min.js"></script>
  <script type="text/javascript" src="<?php echo __ROOT__;?>include/js/Highcharts-4.1.9/highcharts.js"></script>
  <script type="text/javascript">
		var project_root = "<?php echo __ROOT__;?>";
		//在线时间差
		var online_time_cha = <?php echo ONLINE_TIME;?>;
	</script>
  <script>
  $(function () {

		var json = <?php echo json_encode($data_arr); ?>;
			  
		$('#container').highcharts({
	        chart: {
	            type: 'line',
	            style:{
	            	"font-family":"微软雅黑"
	            }
	        },
	        title: {
	            text: '微学习平台'
	        },
	        subtitle: {
	            text: '学习时间'
	        },
	        xAxis: {
	            categories: json.curriculums,
	            title:{
					text:'课时'
		        }
	        },
	        yAxis: {
	            title: {
	                text: '学习时间 (m)'
	            }
	        },
	        tooltip: {
	            enabled: false,
	            formatter: function() {
	                return '<b>'+ this.series.name +'</b><br/>'+this.x +': '+ this.y +'°C';
	            }
	        },
	        plotOptions: {
	            line: {
	                dataLabels: {
	                    enabled: true
	                },
	                enableMouseTracking: false
	            }
	        },
	        series: [
     	        {
	            name: '学习时间',
	            data: json.data
	            }
            ]
	    });
	});
  </script>
  <style type="text/css">
    body{
        font-family: '微软雅黑';
    }   
  </style>
</head>
<body>
  <div id="container" style="width: 100%;"></div>
</body>
</html>