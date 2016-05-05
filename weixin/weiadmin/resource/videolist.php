<?php
    require('../common/init.php');
    require (INCLUDE_PATH.'php/page.class.php');
    
    $this_moday = thisMonday();
    $this_moday_str = date('Y-m-d H:i:s',$this_moday);
    
    $query = "SELECT COUNT(*) FROM `student`";
    $result = mysql_query($query) or die(mysql_error());
    if (mysql_num_rows($result) <= 0) {
        exit('没有用户数据');
    }
    $row = mysql_fetch_row($result);
    $count = $row[0];
    //分页
    $page = new Page($count,15);//传入参数记录总数、每页显示的记录数
    $limit = $page->limit;
    
    $query = "SELECT `student_id`,`student_name` FROM `student` ORDER BY `student_id` {$limit}";
    $result = mysql_query($query) or die(mysql_error());
    if (mysql_num_rows($result) <= 0) {
        exit('没有用户数据');
    }
    $students = array();
    while (($row = mysql_fetch_assoc($result)) != false) {
        $students[$row['student_id']] = $row['student_name'];
    }
    /*
     * 本周数据
     */
    $student_id_str = implode(',', array_keys($students));
    //登录次数、在线时间
    $query = "SELECT COUNT(*) `login_count`,`student_id`,SUM(`online_time`) `online_time` 
               FROM `login_record` WHERE `student_id` IN ({$student_id_str}) 
                AND `login_time`>{$this_moday} GROUP BY `student_id`";
    $result = mysql_query($query) or die(mysql_error());
    if (mysql_num_rows($result) <= 0) {
        exit('没有用户登录数据');
    }
    $student_data = $students;    //格式
    while (($row = mysql_fetch_assoc($result)) != false) {
        $student_data[$row['student_id']] = array('login_count'=>$row['login_count'], 'online_time'=>round($row['online_time']/60));
    }
    //讨论次数
    $query = "SELECT COUNT(*) `dis_count`,`student_id` FROM `discuss` WHERE `student_id` IN ({$student_id_str})
               AND `father_id`=0 AND `time`>'{$this_moday_str}' GROUP BY `student_id`";
    $result = mysql_query($query) or die(mysql_error());
    while (($row = mysql_fetch_assoc($result)) != false) {
        $student_data[$row['student_id']]['dis_count'] = $row['dis_count'];
    }
    /*
     * 历史所有数据
     */
    $query = "SELECT COUNT(*) `login_count`,`student_id`,SUM(`online_time`) `online_time` 
                FROM `login_record` WHERE `student_id` IN ({$student_id_str}) GROUP BY `student_id`";
    $result = mysql_query($query) or die(mysql_error());
    if (mysql_num_rows($result) <= 0) {
        exit('没有用户登录数据');
    }
    $student_data_all = $students;    //格式
    while (($row = mysql_fetch_assoc($result)) != false) {
        $student_data_all[$row['student_id']] = array('login_count'=>$row['login_count'], 'online_time'=>round($row['online_time']/60));
    }
    $query = "SELECT COUNT(*) `dis_count`,`student_id` FROM `discuss` WHERE `student_id` IN ({$student_id_str})
    AND `father_id`=0 GROUP BY `student_id`";
    $result = mysql_query($query) or die(mysql_error());
    while (($row = mysql_fetch_assoc($result)) != false) {
        $student_data_all[$row['student_id']]['dis_count'] = $row['dis_count'];
    }
    
//     var_dump($student_data);
//     var_dump($student_data_all);
//     exit();
    
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel="stylesheet" type="text/css" href="../css/basic.css"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>用户列表</title>
	<style type="text/css">
        table .second-tr td{
	       border-bottom: 2px solid #DDDDDD;
            border-right: 2px solid #FFF;
        	background-color: #47CCFB;
        }
        table .second-tr td:last-child{
        	border: none;
        	border-bottom: 2px solid #DDDDDD;
        }
        table .first-tr th{
	       background-color: #47CCFB;
        }
    </style>
    
    <link rel="stylesheet" type="text/css" href="../../include/js/elFinder-2.1.11/jquery-ui-1.11.4/jquery-ui.min.css">
		<script src="../../include/js/elFinder-2.1.11/jquery-1.12.3.js"></script>
		<script src="../../include/js/elFinder-2.1.11/jquery-ui-1.11.4/jquery-ui.min.js"></script>


		<!-- elFinder CSS (REQUIRED) -->
		<link rel="stylesheet" type="text/css" href="../../include/js/elFinder-2.1.11/css/elfinder.min.css">
		<link rel="stylesheet" type="text/css" href="../../include/js/elFinder-2.1.11/css/theme.css">

		<!-- elFinder JS (REQUIRED) -->
		<script src="../../include/js/elFinder-2.1.11/js/elfinder.min.js"></script>

		<!-- GoogleDocs Quicklook plugin for GoogleDrive Volume (OPTIONAL) -->
		<!--<script src="js/extras/quicklook.googledocs.js"></script>-->

		<!-- elFinder translation (OPTIONAL) -->
		<!--<script src="js/i18n/elfinder.ru.js"></script>-->

		<!-- elFinder initialization (REQUIRED) -->
		<script type="text/javascript" charset="utf-8">
			// Documentation for client options:
			// https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
			$(document).ready(function() {
				$('#elfinder').elfinder({
					url : '../../include/js/elFinder-2.1.11/php/connector.minimal.php',  // connector URL (REQUIRED)
					lang: 'zh_CN'                    // language (OPTIONAL)
				});
			});
		</script>
    
</head>

<body class="bg">

<?php include ROOT_PATH.'weiadmin/common/content-header.html';?>

<div class="container">
	<div id="elfinder"></div>
</div>
</body>
</html>
