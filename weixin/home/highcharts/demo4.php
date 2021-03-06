<?php 
	require_once('../Control/MemberControl.php');
	if(isLogin() == false){
		toLoginPage();
	}
	$query = "SELECT ai.`art_type`, SUM(`read_count`) read_sum FROM `read_behavior` rb INNER JOIN `article_info` ai where 
				rb.`art_id`=ai.`art_id` GROUP BY ai.`art_type`";
	$result = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($result) <= 0) {
		show_message('没有记录');
	}
	$art_types = array();
	$counts = array();
	while ($row = mysql_fetch_assoc($result)) {
		switch ($row['art_type']) {
			case 1:
				$art_type = '文章';
				break;
			case 2:
				$art_type = '图文';
				break;
			case 3:
				$art_type = '图片';
				break;
			case 4:
				$art_type = '视频';
				break;
		}
		$art_types[] = $art_type;
		$counts[] = (int)$row['read_sum'];
	}
	
	$data_arr = array('art_types'=>$art_types, 'counts'=>$counts);
	
	
	// SELECT art_type,SUM(`read_count`) FROM `read_behavior` rb INNER JOIN `article_info` ai WHERE
	// rb.`art_id`=ai.`art_id` GROUP BY ai.art_type;

?>
<!doctype html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
  <script type="text/javascript" src="../../include/js/jquery-1.8.3.min.js"></script>
  <script type="text/javascript" src="../../include/js/Highcharts-4.1.9/highcharts.js"></script>
  <script type="text/javascript" src="../../include/js/Highcharts-4.1.9/modules/exporting.js"></script>
	<script type="text/javascript">
	var json = <?php echo json_encode($data_arr); ?>;
	$(function () {
	    $('#container').highcharts({
	        chart: {
	            type: 'column'
	        },
	        title: {
	            text: '微学习平台'
	        },
	        subtitle: {
	            text: '资源访问次数对比'
	        },
	        xAxis: {
	            categories: 
// 		            ['图文','文章','图片','视频']
	        		json.art_types
	        },
	        yAxis: {
	            min: 0,
	            title: {
	                text: '访问次数'
	            }
	        },
	        tooltip: {
	            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
	            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
	                '<td style="padding:0"><b>{point.y}</b></td></tr>',
	            footerFormat: '</table>',
	            shared: true,
	            useHTML: true
	        },
	        plotOptions: {
	            column: {
	                pointPadding: 0.2,
	                borderWidth: 0
	            }
	        },
	        series: [
	     		{
	            	name: '访问次数',
	            	data: 
// 		            	[900, 500, 755, 800]
	     				json.counts
	        	}
	        ]
	    });
	});
	</script>
</head>
<body>
	<div id="container" style="width: 100%;"></div>
</body>
</html>