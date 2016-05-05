<?php
 require('../common/init.php');
?>
<script>
$(function () { 
	    $('#container1').highcharts({
	        chart: {
	            type: 'column'
	        },
	        title: {
	            text: '文章浏览数'
	        },
	        xAxis: {
	            categories: ['my', 'first', 'chart']
	        },
	        yAxis: {
	            title: {
	                text: 'something'
	            }
	        },
	        series: [{
	            name: 'Jane',
	            data: [1, 0, 4]
	        }, {
	            name: 'John',
	            data: [5, 7, 3]
	        }]
	    });

	    $('#container2').highcharts({
	    	chart: {
	            plotBackgroundColor: null,
	            plotBorderWidth: null,
	            plotShadow: false
	        },
	        title: {
	            text: '微学习平台'
	        },
	        subtitle: {
	            text: '用户省份分布比例'
	        },
	        tooltip: {
	    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
	        },
	        plotOptions: {
	            pie: {
	                allowPointSelect: true,
	                cursor: 'pointer',
	                dataLabels: {
	                    enabled: true,
	                    color: '#000000',
	                    connectorColor: '#000000',
	                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
	                }
	            }
	        },
	        series: [{
	        	type: 'pie',
	            name: '比例',
	            data: [
					{
					    name: '广东',
					    y: 45.0,
					    sliced: true,
					    selected: true
					},
	                ['江苏',   12.8],
	                ['福建',       26.8],
	                ['浙江',    8.5],
	                ['湖南',     6.2],
	                ['湖北',   0.7]
	            ]
	        }]
		});

	    $('#container3').highcharts({
	    	chart: {
	            plotBackgroundColor: null,
	            plotBorderWidth: null,
	            plotShadow: false
	        },
	        title: {
	            text: '微学习平台'
	        },
	        subtitle: {
	            text: '用户性别比例'
	        },
	        tooltip: {
	    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
	        },
	        plotOptions: {
	            pie: {
	                allowPointSelect: true,
	                cursor: 'pointer',
	                dataLabels: {
	                    enabled: true,
	                    color: '#000000',
	                    connectorColor: '#000000',
	                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
	                }
	            }
	        },
	        series: [{
	            type: 'pie',
	            name: '比例',
	            data: [
					{
					    name: '女',
					    y: 69.5,
					    sliced: true,
					    selected: true
					},
					['男',30.5],
	            ]	    		
	        }]
		});

	    $('#container4').highcharts({
	    	chart: {
	            plotBackgroundColor: null,
	            plotBorderWidth: null,
	            plotShadow: false
	        },
	        title: {
	            text: '微学习平台'
	        },
	        subtitle: {
	            text: '用户年龄层次'
	        },
	        tooltip: {
	    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
	        },
	        plotOptions: {
	            pie: {
	                allowPointSelect: true,
	                cursor: 'pointer',
	                dataLabels: {
	                    enabled: true,
	                    color: '#000000',
	                    connectorColor: '#000000',
	                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
	                }
	            }
	        },
	        series: [{
	            type: 'pie',
	            name: '比例',
	            data: [
					{
					    name: '20-25',
					    y: 45,
					    sliced: true,
					},
					['14-19',25],
					['26-31', 20],
					['其他', 10]
	            ]	    		
	        }]
		});
		
	});
</script>
