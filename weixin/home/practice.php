<?php
    require_once ('./Control/MemberControl.php');
    if (isLogin() == false) {
        toLoginPage();
    }
    header('Content-Type:text/html;charset=utf-8');
    if (! isset($_GET['unit_id'])) {
        exit('异常访问');
    }
    $unit_id = $_GET['unit_id'];
    $student_id = $_SESSION['student_id'];
    //判断是否学习所有知识点
    if (!isLearnAllCurriculum($student_id, $unit_id)) {
        show_message('你还没学完本单元 的所有知识点，不能做练习', true);
    }
    //从习题表中查询出习题信息
    $sql = "SELECT `art_class_name`, `practice_content` FROM `practice` p INNER JOIN `art_class` ac
            where `unit_id`={$unit_id} AND p.`unit_id`=ac.`art_class_id`";
    $result = mysql_query($sql) or die(mysql_error());
    if (mysql_num_rows($result) <= 0) {
        show_message('服务器异常！');
    }
    $row = mysql_fetch_assoc($result);
?>


<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>单元习题</title>
	<link rel="stylesheet" type="text/css" href="css/basic.css" />
	<link rel="stylesheet" type="text/css" href="css/practice.css" />
	<script src="../include/js/jquery-1.5.2.min.js"></script>
	<script src="./js/common.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		//项目跟路径
		var project_root = "<?php echo __ROOT__;?>";
		//在线时间差
		var online_time_cha = <?php echo ONLINE_TIME;?>;
	</script>
</head>
<body>
<div class="header">
	<h2><?php echo WEBSITE_NAME;?></h2>
</div>
<div class="evaluate">
    <div class="explain">
        <h4><?php echo $row['art_class_name']?>--习题</h4>
		<div class="explaincon">
			<p>在学习完每个单元的所有知识点之后可以进行知识检测，每个练习都是以选择题的形式进行。在进入练习之前需要完成所有的知识点学习，如果完成一次学习之后没有做到全对，可以选择重做，最多可以练习五次。</p>
		</div>
	</div>
    <form action="Control/BehaviorControl.php?action=practiceSub&unit_id=<?php echo $unit_id ?>" 
    		      method="post">
    	<div class="practice_content">
    	   <?php echo $row['practice_content'];?>
    	</div>
    	<div class="submit">
    	   <input class="submitbtn" type="submit" value="提交" />
    	</div>
    </form>
</div>
</body>
</html>
