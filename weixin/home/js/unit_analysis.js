$(function () {
	/*
	 * 学习路径
	 */
    $('#learn_path').highcharts({
        chart: {
        	zoomType: 'x',
            type: 'spline',
            inverted: false,
            style:{
            	"font-family":"微软雅黑"
            }
        },
        title: {
            text: '单元学习路径'
        },
        xAxis: {
            reversed: false,
            title: {
                enabled: true,
                text: '单元'
            },
            labels: {
                formatter: function() {
                    return learn_path_data.art_class_names[this.value];
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
            data: learn_path_data.data,
        }]
    });
    
    /*
     * 学习成绩
     */
    $('#learn_grade').highcharts({
        chart: {
            zoomType: 'x'
        },
        title: {
            text: '单元学习成绩统计'
        },
        xAxis: [{
            categories: learn_grade_data.units,
            title: {
                text: '单元',
                style: {
                    color: '#89A54E'
                }
            }
        }],
        yAxis: [{ // Primary yAxis
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
        	max:5,
            title: {
                text: '掌握知识次数',
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
	            name: '掌握知识次数',
	            color: '#4572A7',
	            type: 'column',
	            yAxis: 1,
	            data: learn_grade_data.grade_data.unit_learn_time,
	            tooltip: {
	                valueSuffix: '次'
	            }
	        }, 
	        {
	            name: '首次学习成绩',
	            color: '#89A54E',
	            type: 'spline',
	            data: learn_grade_data.grade_data.first,
	            tooltip: {
	            	shared: true,
	                valueSuffix: ''
            	}
        	},
        	{
                type: 'spline',
                name: '二次学习成绩',
                color:'#000000',
                data: learn_grade_data.grade_data.second,
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
                data: learn_grade_data.grade_data.third,
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