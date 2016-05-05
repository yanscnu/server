<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../css/basic.css"/>
<link rel="stylesheet" type="text/css" href="../css/left.css"/>
<link rel="stylesheet" type="text/css" href="../../include/css/Font-Awesome-3.2.1/css/font-awesome.min.css"/>
<script src="../../include/js/jquery-1.5.2.min.js" type="text/javascript" charset="utf-8"></script>
<title>左导航</title>
</head>

<body class="background-color: #FFFFFF;">
	
	<div id="leftnav">
		<div class="search">
			<span>
				<i class="icon-search"></i>
				<input type="text" placeholder="便捷查询" />
			</span>
		</div>
		<div class="leftsidebar_box" style="text-align:center;">
			<dl class="syetem_management">
				<dt><i class="icon-cog icon-large"></i><span>站点管理</span><i class="icon-angle-down icon-large"></i></dt>
				<dd><a href="../website/info.php" target="right" >基本信息</a></dd>
				<dd><a href="../website/sysconfigmod.php" target="right" >修改配置</a></dd>
			</dl>
		
			<dl>
				<dt><i class="icon-list-ul icon-large"></i><span>分类管理</span><i class="icon-angle-down icon-large"></i></dt>
				<dd><a href="../class/classlist.php" target="right">分类列表</a></dd>
				<dd><a href="../class/classadd.php" target="right">添加分类</a></dd>
			</dl>
			
			<dl>
				<dt><i class="icon-pencil icon-large"></i><span>习题管理</span><i class="icon-angle-down icon-large"></i></dt>
				<dd><a href="../practice/practicelist.php" target="right">习题列表</a></dd>
				<dd><a href="../practice/practiceadd.php" target="right">添加习题</a></dd>
			</dl>
			
			<dl>
				<dt><i class="icon-pencil icon-large"></i><span>文章管理</span><i class="icon-angle-down icon-large"></i></dt>
				<dd><a href="../article/artlist.php" target="right">文章列表</a></dd>
				<dd><a href="../article/artadd.php" target="right">添加文章</a></dd>
			</dl>
		
			<dl>
				<dt><i class="icon-bar-chart icon-large"></i><span>数据统计</span><i class="icon-angle-down icon-large"></i></dt>
				<!-- <dd><a href="../analysis/bigdata.php" target="right">用户大数据</a></dd> -->
				<dd><a href="../analysis/resource-access.php" target="right">资源访问</a></dd>
				<dd><a href="../analysis/unit_discuss.php" target="right">讨论统计</a></dd>
				<dd><a href="../analysis/unit_grade.php" target="right">成绩统计</a></dd>
				<dd><a href="../analysis/evaluate.php" target="right">评价统计</a></dd>
			</dl>
		
			<dl>
				<dt><i class="icon-user icon-large"></i><span>用户管理</span><i class="icon-angle-down icon-large"></i></dt>
				<dd><a href="../user/userlist.php" target="right">用户列表</a></dd>
			</dl>
		
			<dl>
				<dt><i class="icon-cloud-upload icon-large"></i><span>素材库管理</span><i class="icon-angle-down icon-large"></i></dt>
				<dd><a href="../resource/resourcelist.php" target="right">素材库</a></dd>
			</dl>
			
			<dl class="exit">
				<dt><a href="action.php?act=exit" target="_self">退出系统</a></dt>
			</dl>
		</div>
	</div>
	
	
	
	<script type="text/javascript">
		var i = 0;
		var arr = new Array('icon-angle-down', 'icon-angle-up');
		$(function(){
			$(".leftsidebar_box dd").hide();
			$(".leftsidebar_box dt").click(function(){
				
				$(".leftsidebar_box dt").css({"background-color":"#FFFFFF"});
				$('dt i').css({'color':'#343342'});
				$('dt span').css({'color':'#343342'});

				$('dt i:last-child').removeClass(arr[1]);
				$('dt i:last-child').addClass(arr[0]);

				var current = (i++)%2;
				var next = i%2;
				
				
				
				$(this).find('i').last().removeClass(arr[current]);
				$(this).find('i').last().addClass(arr[next]);
				
				$(this).find('i').css({'color':'#FFFFFF'});
				$(this).find('span').css({'color':'#FFFFFF'});
				$(this).css({"background-color": "#2D83EA"});
				
				$(this).parent().find('dd').removeClass("menu_chioce");
				$(".menu_chioce").slideUp(); 
				$(this).parent().find('dd').slideToggle();
				$(this).parent().find('dd').addClass("menu_chioce");
				$(".leftsidebar_box dd a").each(function(){
					$(this).removeClass('focus');
				});
			});
			$(".leftsidebar_box dd a").click(function(){
				$(".leftsidebar_box dd a").each(function(){
					$(this).removeClass('focus');
				});
				$(this).addClass('focus');
			});
		})
	</script>
</body>
</html>
