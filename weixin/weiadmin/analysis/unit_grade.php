<?php 
	
	require ('../common/init.php');
	
	$page_name = '数据统计 > 成绩统计';
	
	$units = getUnitList();
	if ($units == false) {
	    exit('没有课程信息');
	}
	
	$query = "SELECT COUNT(*) `count`, SUM(`correct_rate`) `sum`, `unit_id` FROM `practice_record` pr 
	           INNER JOIN `practice` p WHERE pr.`pid`=p.`pid` GROUP BY `unit_id`";
	$result = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($result) <= 0) {
		exit('没有数据');
	}
	$grade_data = array();
	while (($row = mysql_fetch_assoc($result)) != false) {
	    $grade_data[$row['unit_id']] = round($row['sum']/$row['count']*100);
	}
	$units_data = array();
	foreach ($units as $key=>$value) {
	    if (isset($grade_data[$key])) {
            $units_data[] = $grade_data[$key];
	    } else {
	        $units_data[] = null;
	    }
	}
	$data = array('units'=>array_values($units), 'grades'=>$units_data);
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
	var json = <?php echo json_encode($data); ?>;
	$(function () {
	    $('#container1').highcharts({
	        chart: {
	            type: 'line'
	        },
	        title: {
	            text: '单元成绩统计'
	        },
	        xAxis: {
	            categories: json.units,
	        	title:{
					text:'<b>单元</b>',
		        },
	        },
	        yAxis: {
	            min: 0,
	            allowDecimals:false,
	            title: {
	                text: '平均分'
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
	            	name: '平均分',
	            	data: 
	     				json.grades
	        	}
	        ]
	    });	    
	});
	</script>
	
</body>
</html>