<?php 
	
	require ('../common/init.php');
	
	$page_name = '数据统计 > 评价统计';
	
	$units = getUnitList();
	if ($units == false) {
	    exit('没有课程信息');
	}
	
	$unit_ids_str = implode(',', array_keys($units)); 
	
	$query = "SELECT `learn_resource`,`master_degree`,`unit_id` FROM `evaluate_record` WHERE `unit_id` IN ({$unit_ids_str})";
	$result = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($result) <= 0) {
		exit('没有数据');
	}
	
	$s1_learn_resource = $s1_master_degree = array();
	
	foreach ($units as $key=>$value) {
	    $s1_learn_resource[$key] = $s1_master_degree[$key] = 0;
	}
	
	$s2_learn_resource = $s3_learn_resource = $s4_learn_resource = $s1_learn_resource;
	$s2_master_degree = $s3_master_degree = $s4_master_degree = $s1_master_degree;
	
	
	while (($row = mysql_fetch_assoc($result)) != false) {
	    switch ($row['learn_resource']) {
	        case 'A':
	           $s1_learn_resource[$row['unit_id']] += 1;
	           break;
            case 'B':
                $s2_learn_resource[$row['unit_id']] += 1;
                break;
            case 'C':
                $s3_learn_resource[$row['unit_id']] += 1;
               break;
            case 'D':
                $s4_learn_resource[$row['unit_id']] += 1;
                break;
	        default:
	            ;
	           break;
	    }
	   switch ($row['master_degree']) {
	        case 'A':
	           $s1_master_degree[$row['unit_id']] += 1;
	           break;
            case 'B':
                $s2_master_degree[$row['unit_id']] += 1;
                break;
            case 'C':
                $s3_master_degree[$row['unit_id']] += 1;
               break;
            case 'D':
                $s4_master_degree[$row['unit_id']] += 1;
                break;
	        default:
	            ;
	           break;
	    }
	}
	
	$units = array_values($units);
	
	$data_learn_resource = array(
	    's1'=>array_values($s1_learn_resource),
	    's2'=>array_values($s2_learn_resource),
	    's3'=>array_values($s3_learn_resource),
	    's4'=>array_values($s4_learn_resource));
	
	$data_master_degree = array(
	    's1'=>array_values($s1_master_degree),
	    's2'=>array_values($s2_master_degree),
	    's3'=>array_values($s3_master_degree),
	    's4'=>array_values($s4_master_degree));
	
	$data = array('units'=>$units,'data_learn_resource'=>$data_learn_resource,'data_master_degree'=>$data_master_degree);
	
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
		#container1,#container2{
			width: 60%;
			margin: 50px auto;
		}
	</style>

</head>
<body class="bg">

	<?php include ROOT_PATH.'weiadmin/common/content-header.html';?>

	<div id="container1"></div>
	<div id="container2"></div>
	
	
	<script type="text/javascript">
	var json = <?php echo json_encode($data); ?>;
	$(function () {
	    $('#container1').highcharts({
	        chart: {
	            type: 'column'
	        },
	        title: {
	            text: '学习资源评价统计'
	        },
	        xAxis: {
	            categories: json.units
	        },
	        yAxis: {
	            title: {
	                text: '次数'
	            }
	        },
	        tooltip: {
	            enabled: false,
	            formatter: function() {
	                return '<b>'+ this.series.name +'</b><br/>'+this.x +': '+ this.y +'°C';
	            }
	        },
	        plotOptions: {
	        	column: {
	                dataLabels: {
	                    enabled: true
	                },
	                enableMouseTracking: false
	            }
	        },
	        series: [{
	            name: ' 非常好',
	            data: json.data_learn_resource.s1
	        }, {
	        	name: '好',
	            data: json.data_learn_resource.s2
	        },
	        {
	            name: '一般',
	            data: json.data_learn_resource.s3
	        }, {
	        	name: '有待提升',
	            data: json.data_learn_resource.s4
	        }]
	    });
	    $('#container2').highcharts({
	        chart: {
	            type: 'column'
	        },
	        title: {
	            text: '学习掌握程度统计'
	        },
	        xAxis: {
	            categories: json.units
	        },
	        yAxis: {
	            title: {
	                text: '次数'
	            }
	        },
	        tooltip: {
	            enabled: false,
	            formatter: function() {
	                return '<b>'+ this.series.name +'</b><br/>'+this.x +': '+ this.y +'°C';
	            }
	        },
	        plotOptions: {
	        	column: {
	                dataLabels: {
	                    enabled: true
	                },
	                enableMouseTracking: false
	            }
	        },
	        series: [{
	            name: ' 非常好',
	            data: json.data_master_degree.s1
	        }, {
	        	name: '好',
	            data: json.data_master_degree.s2
	        },
	        {
	            name: '一般',
	            data: json.data_master_degree.s3
	        }, {
	        	name: '有待提升',
	            data: json.data_master_degree.s4
	        }]
	    });
	});
	</script>
	
</body>
</html>