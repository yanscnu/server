<?php
require_once ('./home/Control/MemberControl.php');
if (isLogin () == false) {
	toLoginPage();
}
$sql = "select art_class_id,art_class_name,art_class_brief from art_class where art_class_father_id = 0";
$result = mysql_query ( $sql );
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta charset="utf-8">
<title>主页</title>
<link rel="stylesheet" type="text/css" href="index.css" />
<script src="./include/js/jquery-1.5.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="./home/js/common.js" type="text/javascript" charset="utf-8"></script>
<script src="index.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
	//项目跟路径
	var project_root = "<?php echo __ROOT__;?>";
	//在线时间差
	var online_time_cha = <?php echo ONLINE_TIME;?>;
	//jq
	$(document).ready(function(){$(".li1:last").addClass("li4");$(".li1:last").removeClass("li1");});
</script>
</head>
<body>
	<div class="container" style="width: 100%">
		<div class="top">
			<h1>Doers学习平台</h1>
		</div>
		<div class="banner">
			<img src="home/img/indexbanner.jpg" />
		</div>
		<div class="unit">
			<ul>
        		<?php
					$i = 0;
					while ( $row = mysql_fetch_assoc ( $result ) ) {
						$sql1="select * from art_class where art_class_father_id='{$row['art_class_id']}'";
						$result1=mysql_query($sql1);
						if(mysql_num_rows($result1)>0){
							$state=0;
							while($row1=mysql_fetch_array($result1)){
								if(artidsInCurriculum($row1["art_class_id"])){$state=1;}
								}
								if($state==1){
							echo "<li><a class='li1' art_class_id='{$row['art_class_id']}'  href='./home/curriculum.php?art_class_id={$row['art_class_id']}&isunit=true'>{$row['art_class_name']}</a></li>";}else{
								echo "<li><a class='li2' art_class_id='{$row['art_class_id']}'  href=''>{$row['art_class_name']}</a></li>";
								}
							}else{
								echo "<li><a class='li2' art_class_id='{$row['art_class_id']}'  href=''>{$row['art_class_name']}</a></li>";
								}
						//$id = $i % 2 + 1;
//						$i = $i + 1;
//						echo "<li><a class='li{$id}' art_class_id='{$row['art_class_id']}'  href='./home/curriculum.php?art_class_id={$row['art_class_id']}&isunit=true'>{$row['art_class_name']}</a></li>";
					}
				?>
        	</ul>
		</div>
	</div>
</body>
</html>
