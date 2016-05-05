<?php
	require('../common/init.php');
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel="stylesheet" type="text/css" href="../css/basic.css"/>
	<script src="../../include/js/jquery-1.5.2.min.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>文章管理</title>
</head>

<body class="bg">

<?php include ROOT_PATH.'weiadmin/common/content-header.html';?>

<center style="margin-top: 50px;font-size: 50px;">	
<?php
	$action = isset($_GET['act'])?$_GET['act']:null;
	if($action != null){
		if(function_exists($action)){
			$action();
		}else{
			exit('异常访问！参数有误！');
		}
	}else{
	}

	/*
	 * 用于获取文本中的img和video标签中的src的值
	 */	
// 	function getImgPath ($source) {
//		$reg = '/(src=)("|\')([^"\'])*("|\')/';
//		$flag = preg_match_all($reg, $source , $arr1);
//		$filePath = array();
//		$arr1[0] = array_unique($arr1[0]);
//		if($flag){
//			for($i=0;$i<count($arr1[0]);$i++){
//				$src = $arr1[0][$i];
//				$start = strpos($src, '"') ? strpos($src, '"'):strpos($src, "'");
//				$end = strrpos($src, '"') ? strrpos($src, '"'):strrpos($src, "'");
//				$result = substr($src, $start+2 , $end-($start+2));
//				$filePath[$i] =  DOCUMENT_ROOT.$result;	//绝对路径
//			}
//		}
//		return $filePath;
//	}
	
	/*
	 * 用于获取文本中的img和video标签中的src的值
	 */
	function getSrc($str){
        preg_match_all("/(src)=([\"|']?)([^ \"']+\.(gif|jpg|jpeg|bmp|png|mp4|MP4|3GP|AVI|WMV))([\"|']?)/i", $str, $img);
           if (!empty($img[3])) {
               return $img[3];  //注意正则表达式返回的结果的特点，这与自己所写的正则表达式有关
           }
        return null;
    }
	 
	/*
	 *	文章添加的处理 
	 * 	若提交的数据不合法，应将数据返回到添加页面，此处还没实现此功能
	*/	
	
	function art_add(){
		$text = $_POST['content'];
		$title = $_POST['title'];
		$author = $_POST['author'];
		$sort = $_POST['sort'];
		$art_class = $_POST['art_class'];
		$art_type = $_POST['art_type'];
		$state = $_POST['state'];
		$brief = $_POST['brief'];
		$time = date("Y-m-d H:i:s",time());
		$words_num = $_POST['words_num'];
		$thumbnail = "";
		//缩略图上传
		if($_FILES['thumbnail']['error']==0){
			if ((($_FILES["thumbnail"]["type"] == "image/gif") || ($_FILES["thumbnail"]["type"] == "image/jpeg") || ($_FILES["thumbnail"]["type"] == "image/pjpeg"))) {
				$index = strripos($_FILES['thumbnail']['name'], ".");
				$houzhui = substr($_FILES['thumbnail']['name'], $index);
				$time = time();
				$dir = THUMBNAIL_PATH.date("Y-m-d",$time);
				if(!is_dir($dir)){
					mkdir($dir);
				}
				$thumbnail = date("Y-m-d",$time).'/'.$time.$houzhui;	//2016-3-13/2344335457.jpg
				move_uploaded_file($_FILES["thumbnail"]["tmp_name"], THUMBNAIL_PATH.$thumbnail);
			} else {
				echo '<script type="text/javascript">alert("图片格式不正确，请重新选择");history.back();</script>';
				exit;
			}	
		}
		$sql = "insert into article_info(art_class_id,art_title,author,publication_time,art_sort,
							brief,thumbnail,words_num,text,state,art_type) 
					values($art_class,'{$title}','{$author}','{$time}',$sort,
					'{$brief}','{$thumbnail}',$words_num,'{$text}',$state,$art_type)";
		mysql_query($sql);
		if(mysql_affected_rows()>0){
			echo "文章添加成功";
		}else {
			echo "文章添加失败";
		}
	}

	/*
	 *	文章修改的处理 
	 * 	若提交的数据不合法，应将数据返回到添加页面，此处还没实现此功能 
	*/
	function art_mod(){
		$art_id = $_GET["art_id"];
		$text = $_POST['content'];
		$title = $_POST['title'];
		$author = $_POST['author'];
		$sort = $_POST['sort'];
		$art_class = $_POST['art_class'];
		$art_type = $_POST['art_type'];
		$state = $_POST['state'];
		$brief = $_POST['brief'];
		$time = date("Y-m-d H:i:s",time());	
		$words_num = $_POST['words_num'];	
		$thumbnail = $_POST['oldthumbnail'];
		$del_thumbnail = false;
		if($_FILES['thumbnail']['error']==0){
			if ((($_FILES["thumbnail"]["type"] == "image/gif") || ($_FILES["thumbnail"]["type"] == "image/jpeg") || ($_FILES["thumbnail"]["type"] == "image/pjpeg"))) {
				$index = strripos($_FILES['thumbnail']['name'], ".");
				$houzhui = substr($_FILES['thumbnail']['name'], $index);
				
				$time = time();
				$dir = THUMBNAIL_PATH.date("Y-m-d",$time);
				if(!is_dir($dir)){
					mkdir($dir);
				}
				$thumbnail = date("Y-m-d",$time).'/'.$time.$houzhui;	//2016-3-13/2344335457.jpg
				move_uploaded_file($_FILES["thumbnail"]["tmp_name"], THUMBNAIL_PATH.$thumbnail);
				$del_thumbnail = true;
			}else {
				echo '<script type="text/javascript">alert("图片格式不正确，请重新选择");history.back();</script>';
				exit;
			}
		}
		$sql = "select text from article_info where art_id='{$art_id}'";
		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		
		$sql = "update article_info set art_class_id=$art_class , art_title='{$title}' , author='{$author}' , 
					publication_time='{$time}' , art_sort=$sort , brief='{$brief}' , thumbnail='{$thumbnail}' , 
					words_num=$words_num , text='{$text}' , state='{$state}' , art_type=$art_type where art_id='{$art_id}'";
		mysql_query($sql);
		if(mysql_affected_rows()>0){
			//删除旧的缩略图
			if($del_thumbnail){
				delFile(THUMBNAIL_PATH.$_POST['oldthumbnail']);
			}
			
			/**
			 * 考虑到本篇文章内容的图片可能被其他文章引用
			 * 删除可能造成其他文章图片丢失，此功能暂不实现
			 */
//			//文章内容有改动，如果图片改动则删除就图片
//			if($row['text'] != $text){
//				$oldPathArr = getSrc($row['text']);
//				$newPathArr = getSrc($text);
//				//新的内容没有包含图片、视频，则删除所有的
//				if ($newPathArr==null && $oldPathArr!=null) {
//		            foreach ($oldImgPathArr as $v){
//						delFile(DOCUMENT_ROOT.$v);
//		            }
//		        }
//		        //两者都有src，则进行比较，不存在则删除
//		        else if($newPathArr!=null && $oldPathArr!=null){
//		            foreach ($oldPathArr as $v){
//		                if (!in_array($v, $newPathArr)) {
//		                    delFile(DOCUMENT_ROOT.$v);
//		                }
//		            }
//		        }
//				
//			}
			echo "更改成功<br/>";
		}else {
			echo "数据没有改动<br/>";
		}
	}

	/*
	 * 	删除文章的处理
	 */
	function art_del(){
		if(!isset($_GET['art_id'])){
			exit('异常访问！');			
		}
		$art_id = $_GET['art_id'];
		$sql = "select thumbnail,text from article_info where art_id='{$art_id}'";
		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		$sql = "delete from article_info where art_id='{$art_id}'";
		mysql_query($sql);
		if(mysql_affected_rows()>0){
			//删除缩略图
			delFile(THUMBNAIL_PATH.$row['thumbnail']);
			
			/**
			 * 考虑到本篇文章内容的图片可能被其他文章引用
			 * 删除可能造成其他文章图片丢失，此功能暂不实现
			 */
			// 删除对应的上传图片或视频
//			$pathArray = getSrc($row['text']);
//			if($pathArray != null){
//				foreach($pathArray as $v){
//					delFile(DOCUMENT_ROOT.$v);
//				}
//			}
			echo "<script language='javascript'>alert('删除成功！');history.back();</script>";
		}
		else
		{
			echo "<script language='javascript'>alert('删除失败！');history.back();</script>";
		}
	}
	
?>
	</center>
</body>
</html>
