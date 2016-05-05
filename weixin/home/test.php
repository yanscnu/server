<?php 
require_once ('./Control/MemberControl.php');
if (isLogin () == false) {
	toLoginPage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>课程详情</title>
    <script src="../include/js/jquery-1.5.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script>
		//项目跟路径
		var project_root = "<?php echo __ROOT__;?>";
		var begin = (Date.parse(new Date()))/1000;
		$(window).unload(function(){
		    var end = (Date.parse(new Date()))/1000;
			read_time(begin, end);
		});
		function read_time(begin, end){
			var read_time = end-begin;
			$.ajax({
				async:false,
				url: project_root + "home/Control/BehaviorControl.php?action=test",
				type: "post",
				dataType: "json",
				success:function(data){
				}
			});	
		}
	</script>
</head>
<body>
	<a href="register.php">register.php</a>
	<a href="index.php">index.php</a>
	<a href="login.php">login.php</a>
</body>
</html>