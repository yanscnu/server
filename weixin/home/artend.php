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

$sql = "SELECT `art_class_name`, `practice_content` FROM `practice` p INNER JOIN `art_class` ac
        where `unit_id`={$unit_id} AND p.`unit_id`=ac.`art_class_id`";
$result = mysql_query($sql) or die(mysql_error());
if (mysql_num_rows($result) <= 0) {
    exit('异常！！！');
}
$row = mysql_fetch_assoc($result);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>结束页</title>
	<link rel="stylesheet" type="text/css" href="./css/basic.css" />
	<link rel="stylesheet" type="text/css" href="./css/artend.css" />
	<script src="../include/js/jquery-1.5.2.min.js"></script>
	<script src="./js/common.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		//项目跟路径
		var project_root = "<?php echo __ROOT__;?>";
		//在线时间差
		var online_time_cha = <?php echo ONLINE_TIME;?>;
		$(function() {
			$(".select span").click(function(){
				$(this).find('input').attr('checked','true');
				gd();
			});
		});
	</script>

</head>
<div class="header">
	<h2><?php echo WEBSITE_NAME;?></h2>
</div>
<div class="endbanner">
	<img src="img/endbanner.jpg" />
</div>
<div class="evaluate">
	<div class="explain">
		<h4>课程评价说明</h4>
		<div class="explaincon">
			<p>在学习完每个单元的所有知识点之后可以对本单元进行评价，评价方式主要有两种，两道选择题和一道主观题，还可以对本单元的课程向教学老师和管理者提出你的宝贵建议。</p>
		</div>
	</div>
<form action="Control/MemberControl.php?action=evaluate&unit_id=<?php echo $unit_id ?>" 
		      method="post">
	<div class="proposal">
		<div class="suggest">
		      <h2>感受和建议</h2>
			 <textarea id="proposaltext" name="suggestion"></textarea>
		</div>
		<div>
			<ul>
			     <li>
			        <p class="title">
                        <span>1</span>请你对本节课的学习资源进行评价
                    </p>
                    <p class="select">
                        <span><input type="radio" name="learn_resource" value="A" /> A.非常好</span>
                        <span><input type="radio" name="learn_resource" value="B" /> B.好</span>
                    </p> 
                    <p class="select">
                        <span><input type="radio" name="learn_resource" value="C" /> C.一般</span>
                        <span><input type="radio" name="learn_resource" value="D" /> D.有待提升</span>
                    </p>
			     </li>
			     <li>
			        <p class="title">
                        <span>2</span>请你对本节课的学习掌握程度进行评价
                    </p>
                    <p class="select">
                        <span><input type="radio" name="master_degree" value="A" /> A.非常好</span>
                        <span><input type="radio" name="master_degree" value="B" /> B.好</span>
                    </p> 
                    <p class="select">
                        <span><input type="radio" name="master_degree" value="C" /> C.一般</span>
                        <span><input type="radio" name="master_degree" value="D" /> D.有待提升</span>
                    </p>
			     </li>
			</ul>
		</div>
	</div>
	<div class="submit">
	   <input class="submitbtn" type="submit" value="提交" />
	</div>
</form>
</div>
<body>
</body>
</html>
