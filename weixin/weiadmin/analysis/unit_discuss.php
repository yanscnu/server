<?php 
	
	require ('../common/init.php');
	
	$page_name = '数据统计 > 讨论统计';
	
	$query = "SELECT ac.`art_class_name`,COUNT(*) `discuss_sum` FROM `discuss` dis INNER JOIN `art_class` ac 
				WHERE dis.`father_id`=0 AND dis.`curriculum_id`=ac.`art_class_id`
	               GROUP BY `art_class_sort` ORDER BY ac.`art_class_sort`";
	$result = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($result) <= 0) {
		exit('没有数据');
	}
	$units = array();
	$counts = array();
	while (($row = mysql_fetch_assoc($result)) != false) {
		$units[] = $row['art_class_name'];
		$counts[] = (int)$row['discuss_sum'];
	}

	$data_arr = array('curriculums'=>$units, 'counts'=>$counts);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>课时讨论分析</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
	<link rel="stylesheet" type="text/css" href="../css/basic.css"/>
	<script type="text/javascript" src="../../include/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="../../include/js/Highcharts-4.1.9/highcharts.js"></script>
	<script type="text/javascript" src="../../include/js/Highcharts-4.1.9/modules/exporting.js"></script>	
	
	<style type="text/css">
		#container1{
			width: 60%;
			margin: 50px auto;
		}
	</style>

</head>
<body class="bg">

	<?php include ROOT_PATH.'weiadmin/common/content-header.html';?>

	<div id="container1"></div>
	
	
	<script type="text/javascript">
	var json = <?php echo json_encode($data_arr); ?>;
	$(function () {
	    $('#container1').highcharts({
	        chart: {
	            type: 'column'
	        },
	        title: {
	            text: '微学习平台'
	        },
	        subtitle: {
	            text: '单元1课时讨论统计'
	        },
	        xAxis: {
	            categories: json.curriculums,
	        	title:{
					text:'<b>课时</b>',
		        },
	        },
	        yAxis: {
	            min: 0,
	            allowDecimals:false,
	            title: {
	                text: '讨论次数'
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
	            	name: '讨论次数',
	            	data: 
	     				json.counts
	        	}
	        ]
	    });	    
	});
	</script>
	
</body>
</html>