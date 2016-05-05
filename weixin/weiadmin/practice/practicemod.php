<?php
	require ('../common/init.php');
	
	if (!isset($_GET['pid'])) {
		exit('非法访问');
	}
	$pid = $_GET['pid'];
	$sql = "SELECT `unit_id`,`practice_content` FROM `practice` where `pid`={$pid}";
	$result = mysql_query($sql) or die(mysql_error());
	if (mysql_num_rows($result) <= 0) {
		exit('异常');
	}
	$row = mysql_fetch_assoc($result);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>习题添加</title>
	<link rel="stylesheet" type="text/css" href="../css/basic.css"/>
	<script src="../../include/js/jquery-1.5.2.min.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css">
		.practiceadd{
			width: 400px;
			margin: 0 auto;
			text-align: center;
			padding: 10px 0 20px 0;
		}
		.practiceadd h2{
			text-align: center;
		}
		.practiceadd .unit-select{
			padding: 10px 0;
		}
		.practiceadd .unit-select select{
			width: 200px;
			height: 25px;
		}
		.ueditor{
			
		}
		.operation{
			padding: 20px 0 0 0;
		}
		.operation .button{
			border: none;
			outline: none;
			width: 60px;
			height: 30px;
			line-height: 30px;
			cursor: pointer;
		}
		.operation input[type=submit]:hover{
			background-color: #FF6600;
			color: #FFFFFF;
		}
		.operation input[type=reset]:hover{
			background-color: #EA2A2A;
			color: #FFFFFF;
		}
	</style>
</head>

<body class="bg">

<?php include ROOT_PATH.'weiadmin/common/content-header.html';?>

<div class="container">
<form id="art_form" action="practiceaction.php?act=practice_mod" method="post" enctype="multipart/form-data">
	<input type="hidden" name="pid" value="<?php echo $pid?>"/>
	<div class="practiceadd">
		<h2>修改习题</h2>
		<div class="unit-select">
			<span>所属单元：</span>
			<select name="unit_id">
				<?php
				//实现数据查询
				$sql_class = "select `art_class_id`,`art_class_name` from `art_class` where `art_class_father_id`=0 order by `art_class_sort`";
				$result_class = mysql_query($sql_class);
				//遍历解析输出内容
				while ($row_class = mysql_fetch_assoc($result_class)) {
					if ($row['unit_id'] == $row_class['art_class_id']) {
						echo "<option selected='true' value='{$row_class['art_class_id']}'>{$row_class['art_class_name']}</option>";
					} else {
						echo "<option value='{$row_class['art_class_id']}'>{$row_class['art_class_name']}</option>";
					}
				}
				mysql_free_result($result_class);
				?>
			</select>
		</div>
		<div class="ueditor">
			<script id="container" name="content" type="text/plain"><?php echo $row['practice_content'];?></script>
		</div>
		
		<div class="operation">
			<input type="submit" class="button" value="提交"/>&nbsp;&nbsp;
			<input type="reset" class="button" value="重置"/>
		</div>
		
	</div>
</form>
</div>
    <script type="text/javascript" charset="utf-8" src="../../include/Formdesign4_1_Ueditor1_4_3/js/ueditor/ueditor.config.js"></script>
	<script type="text/javascript" charset="utf-8" src="../../include/Formdesign4_1_Ueditor1_4_3/js/ueditor/ueditor.all.js"></script>
	<script type="text/javascript" charset="utf-8" src="../../include/Formdesign4_1_Ueditor1_4_3/js/ueditor/lang/zh-cn/zh-cn.js"></script>
	<!--Fromdesign扩展--->
	<script type="text/javascript" charset="utf-8" src="../../include/Formdesign4_1_Ueditor1_4_3/js/ueditor/formdesign/leipi.formdesign.v4.js"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
	    var ue = UE.getEditor('container', 
	    {
			initialFrameWidth: 400 //初始化编辑器宽度,默认1000
			,initialFrameHeight: 500,
			toolleipi:true,
			toolbars: [
					['undo', 'redo', 'indent','bold', 'italic', 'lineheight','underline', 'fontborder', 'strikethrough', 
						'horizontal','superscript', 'subscript', 'removeformat', 'formatmatch', 'simpleupload',
						'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 
						'backcolor', 'insertorderedlist', 'insertunorderedlist', 
						'selectall', 'cleardoc']
						
// 			           [
// 		        'undo', //撤销
// 		        'redo', //重做
// 		        'bold', //加粗
// 		        'indent', //首行缩进
// 		        'italic', //斜体
// 		        'underline', //下划线
// 		        'strikethrough', //删除线
// 		        'subscript', //下标
// 		        'fontborder', //字符边框
// 		        'superscript', //上标
// 		        'formatmatch', //格式刷
// 		        'blockquote', //引用
// 		        'pasteplain', //纯文本粘贴模式
// 		        'selectall', //全选
// 		        'preview', //预览
// 		        'horizontal', //分隔线
// 		        'removeformat', //清除格式
// 		        'time', //时间
// 		        'date', //日期
// 		        'fontfamily', //字体
// 		        'fontsize', //字号
// 		        'paragraph', //段落格式
// 		        'spechars', //特殊字符
// 		        'searchreplace', //查询替换
// 		        'help', //帮助
// 		        'justifyleft', //居左对齐
// 		        'justifyright', //居右对齐
// 		        'justifycenter', //居中对齐
// 		        'justifyjustify', //两端对齐
// 		        'forecolor', //字体颜色
// 		        'backcolor', //背景色
// 		        'insertorderedlist', //有序列表
// 		        'insertunorderedlist', //无序列表
// 		        'rowspacingtop', //段前距
// 		        'rowspacingbottom', //段后距
// 		        'pagebreak', //分页
// 		        'lineheight', //行间距
// 		        'edittip ', //编辑提示
// 		        'customstyle', //自定义标题
// 		        'autotypeset', //自动排版
// 		        'touppercase', //字母大写
// 		        'tolowercase', //字母小写
// 		        'background', //背景
// 		        'drafts', // 从草稿箱加载
// 		        ]
			]
		});
	</script>
    <script type="text/javascript">
	    $(document).ready(function() {
			$("input[type=submit]").click(function() {
				return confirm("确定要提交吗？");
			});
			$("input[type=reset]").click(function() {
				return confirm("重置后所有信息将清空，确定要重置吗？");
			});
	    });
    </script>
</body>
</html>