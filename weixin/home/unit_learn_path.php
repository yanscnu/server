<?php
	require_once('./Control/MemberControl.php');
	if(isLogin() == false){
		toLoginPage();
	}
	//引入用户分析类
	require ROOT_PATH.'lib/UserAnalysis.class.php';
	
	$student_id = $_SESSION['student_id'];
	
// 	$query = "SELECT `begin_time`,`learn_time` FROM `curriculum_learn` WHERE `student_id`={$student_id}
// 	ORDER BY `begin_time` DESC LIMIT 1";
// 	$result = mysql_query($query) or die(mysql_error());
// 	if (mysql_num_rows($result) <= 0) {
// 		show_message('该单元没有任何学习记录，不能生成学习路径！', true);
// 	}
// 	$userAnalysis = new UserAnalysis($student_id);
// 	$data_arr = $userAnalysis->createUintLearnPathData();
	
	
	/**
	 * 修改需求
	 * 完成了单元所有课时的学习才可以进行习题测试
	 * 完成了每个知识点+完成了习题 = 一次学习
	 * 习题最多可以做5次
	 */
	
	$query = "SELECT `unit_id`,`answer_time` FROM `practice_record` pr INNER JOIN `practice` p 
				WHERE `student_id`={$student_id} AND pr.`pid`=p.`pid` ORDER BY `answer_time`";
	$result = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($result) <= 0) {
		show_message('你还没完成学习', true);
	}
	$answer_time_arr = array();
	while ($row = mysql_fetch_assoc($result)) {
		$answer_time_arr[] = $row;
	}
	$userAnalysis = new UserAnalysis($student_id);
	$data_arr = $userAnalysis->createUintLearnPathData($answer_time_arr);
	

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
  <script>
  $(function () {

		var json = <?php echo json_encode($data_arr); ?>;
			  
	    $('#container').highcharts({
	        chart: {
	            type: 'spline',
	            inverted: false
	        },
	        title: {
	            text: '个人学习分析'
	        },
	        subtitle: {
	            text: '学习路径'
	        },
	        xAxis: {
	            reversed: false,
	            title: {
	                enabled: true,
	                text: '单元'
	            },
	            labels: {
	                formatter: function() {
// 	                    return json.art_class_names[this.value];
						return this.value;
	                },
	            },
	            maxPadding: 0.05,
	            showLastLabel: true,
	            allowDecimals:false
	        },
	        yAxis: {
	            title: {
	                text: '学习时间'
	            },
	            labels: {
	                formatter: function() {
	                    return this.value + 'm';
	                }
	            },
	            lineWidth: 1
	        },
	        legend: {
	        	title: {
	                text: '说明:<br/>●首次学习<br/>■二次学习<br/>▲三次学习',
	                style: {
	                }
	            },
	            layout: 'vertical',
	            align: 'center',
	            verticalAlign: 'bottom',
	        },
	        tooltip: {
	            headerFormat: '<b>{series.name}</b><br/>',
	            pointFormat: '单元'+'{point.x} : {point.y}'+'m'
	        },
	        plotOptions: {
	            spline: {
	                marker: {
	                    enable: false
	                }
	            }
	        },
	        series: [{
	            name: '学习时间',
	            data: 
// 		            json.data,
		            [
		   	            [1, 15], 
		   	            [2, 10], 
		   	            [3, 15], 
		   	         	{	
		   	            	marker: {
		                		symbol: 'square',
		                      	lineColor: null,
		                      	lineWidth: 2
		                	},
		                	x:1,
		                	y:5
		   	            },
		   	            [4, 25], 
		   	            [5, 18],
		   	            {	
		   	            	marker: {
		                		symbol: 'square',
		                      	lineColor: null,
		                      	lineWidth: 2
		                	},
		                	x:3,
		                	y:5
		   	            },
		                [6, 30], 
		                [7,20],
		                {	
		   	            	marker: {
		                		symbol: 'triangle',
		                      	lineColor: null,
		                      	lineWidth: 2
		                	},
		                	x:3,
		                	y:8
		   	            },
		   	            [8,20]
            		],
	        }]
	    });
	});
  </script>
</head>
<body>
  <div id="container" style="width: 100%;"></div>
</body>
</html>