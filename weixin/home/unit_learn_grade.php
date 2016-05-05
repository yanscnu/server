<?php
	require_once('./Control/MemberControl.php');
	if(isLogin() == false){
		toLoginPage();
	}
	//引入用户分析类
	require ROOT_PATH.'lib/UserAnalysis.class.php';

	$student_id = $_SESSION['student_id'];
	
	$query = "SELECT `begin_time`,`learn_time` FROM `curriculum_learn` WHERE `student_id`={$student_id} 
				ORDER BY `begin_time` DESC LIMIT 1";	//取出最新学习的课时的开始时间和学习的时间长度
	$result = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($result) <= 0) {
		show_message('没有学习记录，不能生成学习成绩统计', true);
	}
	$row = mysql_fetch_assoc($result);
	$begin_time = $row['begin_time'];
	$learn_time = $row['learn_time'];
	$query = "SELECT `lg_id`,`last_time` FROM `learn_grade` WHERE `student_id`={$student_id}";
	$result = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($result) > 0) {
	$row = mysql_fetch_assoc($result);
		//有新的学习数据，需要更新learn_grade表的成绩统计
		if ((strtotime($begin_time)+$learn_time)  > strtotime($row['last_time'])) {
			$userAnalysis = new UserAnalysis($student_id);
			$data_arr = $userAnalysis->createLearnGradeData();
			if ($data_arr == false) {
				exit('出错！');
			}
			//更新路径到learn_grade表中
			$learn_grade_content = serialize($data_arr);
			$query = "UPDATE `learn_grade` SET `learn_grade_content`='{$learn_grade_content}',
						`last_time`=NOW() WHERE `lg_id`={$row['lg_id']}";
			mysql_query($query) or die(mysql_error());
		} 
		//直接从learn_grade表取出路径信息
		else {
			$query = "SELECT `learn_grade_content` FROM `learn_grade` WHERE `lg_id`={$row['lg_id']}";
			$result = mysql_query($query);
			$row = mysql_fetch_assoc($result);
			$data_arr = unserialize($row['learn_grade_content']);
		}
	} 
	//learn_grade没有学习成绩统计信息
	else {
		//生成学习路径
		$userAnalysis = new UserAnalysis($student_id);
		$data_arr = $userAnalysis->createLearnGradeData();
		if ($data_arr == false) {
			exit('出错！');
		}
		//插入路径到learn_path表中
		$learn_grade_content = serialize($data_arr);
		$query = "INSERT INTO `learn_grade`(`student_id`, `learn_grade_content`, `last_time`)
		VALUES({$student_id}, '{$learn_grade_content}', NOW())";
		mysql_query($query) or die(mysql_error());
	}
	
	
	
?>
<!doctype html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
  <script type="text/javascript" src="../include/js/jquery-1.8.3.min.js"></script>
  <script type="text/javascript" src="../include/js/Highcharts-4.1.9/highcharts.js"></script>
  <script type="text/javascript" src="../include/js/Highcharts-4.1.9/modules/exporting.js"></script>
  <script>
  $(function () {
	  	var json = <?php echo json_encode($data_arr);?>;
	    $('#container').highcharts({
	        chart: {
	            zoomType: 'xy'
	        },
	        title: {
	            text: '微学习平台'
	        },
	        subtitle: {
	            text: '学习成绩统计'
	        },
	        xAxis: [{
	            categories: json.units,
	            title: {
	                text: '单元',
	                style: {
	                    color: '#89A54E'
	                }
	            }
	        }],
	        yAxis: [{ // Primary yAxis
		        min:50,
		        max:100,
	            labels: {
	                format: '{value}',
	                style: {
	                    color: '#89A54E'
	                }
	            },
	            title: {
	                text: '学习成绩',
	                style: {
	                    color: '#89A54E'
	                }
	            }
	        }, { // Secondary yAxis
		        min:5,
	            title: {
	                text: '学习时间(/分钟)',
	                style: {
	                    color: '#4572A7'
	                }
	            },
	            labels: {
	                format: '{value}',
	                style: {
	                    color: '#4572A7'
	                }
	            },
	            opposite: true
	        }],
	        tooltip: {
	            shared: true
	        },
	        legend: {
	        	layout: 'vertical',
	            align: 'center',
	            verticalAlign: 'bottom',
	            backgroundColor: '#FFFFFF'
	        },
	        series: [
		     	{
		            name: '学习时间',
		            color: '#4572A7',
		            type: 'column',
		            yAxis: 1,
		            data: json.grade_data.unit_learn_time,
		            tooltip: {
		                valueSuffix: '分钟'
		            }
		        }, 
		        {
		            name: '首次学习成绩',
		            color: '#89A54E',
		            type: 'spline',
		            data: json.grade_data.first,
		            tooltip: {
		            	shared: true,
		                valueSuffix: ''
	            	}
	        	},
	        	{
	                type: 'spline',
	                name: '二次学习成绩',
	                color:'#000000',
	                data: json.grade_data.second,
	                marker: {
	                    square: 4
	                },
	                tooltip: {
		                valueSuffix: ''
	            	}
	            },
	            {
	                type: 'spline',
	                name: '三次学习成绩',
	                color:'#FF0000',
	                data: json.grade_data.third,
	                marker: {
	                	triangle: 4
	                },
	                tooltip: {
		                valueSuffix: ''
	            	}
	            }
	        ],
	        exporting: {
	        },
	    });
	});
  </script>
</head>
<body>
  <div id="container" style="width:100%;"></div>
</body>
</html>