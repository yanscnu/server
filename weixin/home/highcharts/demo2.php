<?php

?>

<!doctype html>
<html lang="en">
<head>
  <script type="text/javascript" src="../../include/js/jquery-1.8.3.min.js"></script>
  <script type="text/javascript" src="../../include/js/Highcharts-4.1.9/highcharts.js"></script>
  <script>
  $(function () {
	    $('#container').highcharts({
	        title: {
	            text: 'Monthly Average Temperature',
	            x: -20 //center
	        },
	        subtitle: {
	            text: 'Source: WorldClimate.com',
	            x: -20
	        },
	        xAxis: {
	            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
	        },
	        yAxis: {
	            title: {
	                text: 'Temperature (°C)'
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        tooltip: {
	            valueSuffix: '°C'
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	        series: [{
	            name: 'Tokyo',
	            data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
	        }]
	    });
	});
  </script>
</head>
<body>
  <div id="container" style="width:600px;height:400px"></div>
</body>
</html>