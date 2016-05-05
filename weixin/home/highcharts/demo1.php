<?php
	require_once('../Control/MemberControl.php');
	if(isLogin() == false){
		toLoginPage();
	}
	//引入用户分析类
	require ROOT_PATH.'lib/UserAnalysis.class.php';
	
	$student_id = $_SESSION['student_id'];
	$unit_id = 34;
	//是否有
	$query = "SELECT `begin_time` FROM `curriculum_learn` INNER JOIN `art_class` WHERE 
				`student_id`={$student_id} AND `unit_id`={$unit_id} ORDER BY `begin_time` DESC LIMIT 1";
	$result = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($result) <= 0) {
		show_message('该单元没有任何学习记录，不能生成学习路径！', true);
	}
	$row = mysql_fetch_assoc($result);
	$begin_time = $row['begin_time'];
	$query = "SELECT `lp_id`,`last_time` FROM `learn_path` WHERE `student_id`={$student_id} AND `unit_id`={$unit_id}";
	$result = mysql_query($query) or die(mysql_error());
	//learn_path表有路径信息
	if (mysql_num_rows($result) > 0) {
		$row = mysql_fetch_assoc($result);
		//有新的学习数据，需要更新learn_path表的学习路径
		if (strtotime($begin_time) > strtotime($row['last_time'])) {
			$userAnalysis = new UserAnalysis($student_id);
			$data_arr = $userAnalysis->createLearnPathData($unit_id);
			//更新路径到learn_path表中
			$learn_path_content = serialize($data_arr);
			$query = "UPDATE `learn_path` SET `learn_path_content`={$learn_path_content},
						`last_time`=NOW() WHERE `lp_id`={$row['lp_id']}";
			mysql_query($query) or die(mysql_error());
		} 
		//直接从learn_path表取出路径信息
		else {
			$query = "SELECT `learn_path_content` FROM `learn_path` WHERE `lp_id`={$row['lp_id']}";
			$result = mysql_query($query);
			$row = mysql_fetch_assoc($result);
			$data_arr = unserialize($row['learn_path_content']);
		}
	}
	//learn_path没有路径信息
	else {
		//生成学习路径
		$userAnalysis = new UserAnalysis($student_id);
		$data_arr = $userAnalysis->createLearnPathData($unit_id);
		//插入路径到learn_path表中
		$learn_path_content = serialize($data_arr);
		$query = "INSERT INTO `learn_path`(`student_id`, `unit_id`, `learn_path_content`, `last_time`) 
					VALUES({$student_id}, {$unit_id}, '$learn_path_content', NOW())";
		mysql_query($query) or die(mysql_error());
	}
	
	
// 	exit(json_encode($data_arr));
	

?>

<!doctype html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
  <script type="text/javascript" src="../../include/js/jquery-1.8.3.min.js"></script>
  <script type="text/javascript" src="../../include/js/Highcharts-4.1.9/highcharts.js"></script>
  <script type="text/javascript" src="../../include/js/Highcharts-4.1.9/modules/exporting.js"></script>
  <script>
  $(function () {

		var json = <?php echo json_encode($data_arr); ?>;
	  
	    $('#container').highcharts({
	        chart: {
	        	zoomType: 'xy',
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
	                text: '课时'
	            },
	            labels: {
	                formatter: function() {
	                    return '课时'+this.value;
	                },
	            },
	            maxPadding: 0.05,
	            showLastLabel: true,
	            allowDecimals:false,
	            lineWidth: 0,
	        },
	        yAxis: {
	            title: {
	                text: '学习时间(/分钟)'
	            },
	            labels: {
	                formatter: function() {
	                    return this.value;
	                }
	            },
	            lineWidth: 1,
	            allowDecimals:false
	        },
	        legend: {
	        	title: {
	                text: '说明：<br/>● 首次学习<br />■ 二次学习<br />▲ 三次学习',
	                style: {
	                    fontStyle: 'italic',
	                }
	            },
	            layout: 'vertical',
	            align: 'center',
	            verticalAlign: 'bottom',
	            backgroundColor: '#FFFFFF'
	        },
	        tooltip: {
	        	headerFormat: '<b>{series.name}</b><br/>',
	            pointFormat: '课时'+'{point.x} : {point.y}'+'m'
	        },
	        plotOptions: {
	            spline: {
	                marker: {
	                    enable: false
	                }
	            },
// 	        	series: { 
// 		        	cursor: 'pointer', 
// 		        	events: { 
// 			        	click: function(event) { 
// 				        	$("#result").html("Result : index = "+event.point.x+" , series = "+this.name + ', x = '+event.point.category+' ,y = '+event.point.y);
// 				        	$('#result').css({"display":"block","top":(event.x+10)+"px","left":(event.y+10)+"px"}); 
// // 				        	alert('index = '+ Math.round(event.x)+ 'x = '+event.point.category+' ,y = '+event.y); 
// 				        } ,
// 			            mouseout: function(event) { 
// 			            	$('#result').css({"display":"none"});
// // 					        	$("#result").html("<b>Result : index = "+event.point.x+" , series = "+this.name + ', x = '+event.point.category+' ,y = '+event.point.y+"</b>"); 
// // 				        	alert('index = '+ Math.round(event.x)+ 'x = '+event.point.category+' ,y = '+event.y); 
// 				        } 
// 		        	} 
// 	        	}
	        },
	        series: [{
	            name: '学习时间',
	            data: 
		            json.data,
	        }],
	        exporting: {
	            
	        },
		});
	});
  </script>
</head>
<body>
  <div id="container" style="width: 100%;"></div>
</body>
</html>