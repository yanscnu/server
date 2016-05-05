<?php
	require ('../common/init.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>文章添加</title>
	<link rel="stylesheet" type="text/css" href="../css/basic.css"/>
	<link rel="stylesheet" type="text/css" href="../css/article.css"/>
	<script src="../../include/js/jquery-1.5.2.min.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body class="bg">

<?php include ROOT_PATH.'weiadmin/common/content-header.html';?>

<div class="container artadd">
	<h2>添加新文章</h2>
	<form id="art_form" action="artaction.php?act=art_add" method="post" enctype="multipart/form-data">
	<div class="addartleft">
		<span>标题：</span>
			<input type="text" name="title" id="title" class="inputClass" value=""/>
			<label class="errorClass" id="titleError"></label>
		<br /><br />
		<span>作者：</span>
			<input type="text" name="author" id="author" class="inputClass" value=""/>
			<label class="errorClass" id="authorError" ></label>
		<br /><br />
		<span>排序：</span>
			<input type="text" name="sort" id="sort" class="inputClass" value=""/>
			<label class="errorClass" id="sortError"></label>
		<!--<span>发表时间：</span><input type="date" name="date" id="date" value="<?php echo isset($row['art_sort'])?$row['art_sort']:date('Y-m-d H:i:s',time()) ?>"/>-->
		<br /><br />
		<span>类别：</span>
		<select name="art_class" id="art_class" class="inputClass" style="width: 180px;">
			<?php
			//实现数据查询
			$sql_class = "select * from art_class order by concat(path,art_class_id)";
			$result_class = mysql_query($sql_class);
			//遍历解析输出内容
			while ($row_class = mysql_fetch_assoc($result_class)) {
				$m = substr_count($row_class['path'], ",") - 1;
				//缩进的空格的数量
				$str_pad = str_pad("", $m * 6 * 2, "&nbsp;");
				//根分类不可选
				if ($row_class['art_class_father_id'] == 0) {
					$disabled = "disabled";
				} else {
					$disabled = "";
				}
				echo "<option {$disabled} value={$row_class['art_class_id']}>{$str_pad}{$row_class['art_class_name']}</option>";
			}
			mysql_free_result($result_class);
			?>
		</select>
		<br /><br />
		<span>类型：</span>
			<input type="radio" value="1" name="art_type" checked="checked"/>文字
			<input type="radio" value="2" name="art_type" />图文
			<input type="radio" value="3" name="art_type" />视频
		<br /><br />
		<span>状态：</span>
			<input type="radio" value="0" name="state" />草稿
			<input type="radio" value="1" name="state" checked="checked"/>发布
			<input type="radio" value="2" name="state" />回收站
		<br /><br />
		<span>略缩图：</span>
			<input type="file" id="thumbnail" name="thumbnail" />
			<!--<input type="hidden" name="oldthumbnail" value="<?php echo isset($row['thumbnail'])?$row['thumbnail']:"" ?>" />-->
			<!--</span><input type="button" name="upload" id="upload"  value="上传" /> -->
			<label class="errorClass" id="thumbnailError" ></label>
		<br /><br />
		<span>简介：</span>
			<br />
			<textarea cols="43" rows="5" name="brief" id="brief"></textarea>
			<br />
			<label class="errorClass" id="briefError" ></label>
		<br /><br />
		
		<div style="margin-left: 20px;">
			<input type="submit" id="submit" value="<?php echo isset($_GET['art_id'])?"提交更改":"提交" ?>" />
			<input id="reset" type="reset" />
		</div>
		
	</div>
	
	<!--统计words_num,使用ueditor的函数,如后面的js的代码-->
	<input type="hidden" id="words_num" name="words_num" value="" />
	
	<!-- ueditor编辑器 -->
	<div class="ueditor">
		<script id="container" name="content" type="text/plain">
			<?php echo isset($row['text'])?$row['text']:"" ?>
		</script>
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
			initialFrameWidth: 500 //初始化编辑器宽度,默认1000
			,initialFrameHeight: 700,
			toolleipi:true
		});
	</script>
    <script type="text/javascript">
	    $(document).ready(function() {
			$("#submit").click(function() {
				$("#words_num").val(UE.getEditor('container').getContentLength(true));
				return confirm("确定要提交吗？");
			});
	    });
    </script>
    <script src="../js/art_addmod.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>
