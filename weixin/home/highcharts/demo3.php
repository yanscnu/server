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
	    $('#container').highcharts({
	        chart: {
	            zoomType: 'xy'
	        },
	        title: {
	            text: '微学习平台'
	        },
	        subtitle: {
	            text: '学习情况'
	        },
	        xAxis: [{
	            categories: ['单元1', '单元2', '单元3', '单元4', '单元5', '单元6',
	                '单元7', '单元8', '单元9', '单元10']
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
	                text: '掌握知识时间(/分钟)',
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
		            name: '掌握知识时间',
		            color: '#4572A7',
		            type: 'column',
		            yAxis: 1,
		            data: [10, 15, 10, 15, 30, 20, 10, 5, 20, 35],
		            tooltip: {
		                valueSuffix: '分钟'
		            }
		        }, 
		        {
		            name: '首次学习成绩',
		            color: '#89A54E',
		            type: 'spline',
		            data: [70, 80, 80, 85, 70, 85, 60, 75, 100, 95],
		            tooltip: {
		            	shared: true,
		                valueSuffix: ''
	            	}
	        	},
	        	{
	                type: 'spline',
	                name: '二次学习成绩',
	                color:'#000000',
	                data: [90, 90, 85, null, 90, null, 80, 95, null, null],
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
	                data: [100, null, null, null, 100, null, 100, null, null, null],
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