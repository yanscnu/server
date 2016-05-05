<?php
	require_once('./Control/MemberControl.php');
	if(isLogin() == false){
		toLoginPage();
	}
	session_start();
	header('Content-Type:text/html;charset=utf-8');
	if (!isset($_GET['art_id'])) {
		exit('异常访问');
	}
	$current_art_id = $_GET['art_id'];
	$current_curriculum_id = parentId($current_art_id, 'article');
	$current_unit_id = parentId($current_curriculum_id, 'curriculum');
	$article = artInfo($_GET['art_id']);
	$curriculumids = curriculumidsInUnit($current_unit_id);
	
// 	if (getNextCurriculum($current_curriculum_id, $curriculumids) == false) {
// 	    $lastart_id = getLastArticle($current_curriculum_id);
// 	    if ($lastart_id == $current_art_id) {
// 	        $is_last_art = 'true';
// 	    }
// 	}
	
// 	var_dump($curriculumids);
// 	var_dump($current_art_id);
// 	var_dump($current_curriculum_id);
// 	var_dump($current_unit_id);

	
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>课程详情</title>
    <link rel="stylesheet" type="text/css" href="./css/basic.css" />
	<link rel="stylesheet" type="text/css" href="./css/artdetail.css" />
	<script src="../include/js/jquery-1.5.2.min.js"></script>
	<script src="./js/common.js" type="text/javascript" charset="utf-8"></script>
	<script>
		var art_id = "<?php echo $current_art_id; ?>";
		var curriculum_id = "<?php echo $current_curriculum_id; ?>";
		var unit_id = "<?php echo $current_unit_id;?>";
		//项目跟路径
		var project_root = "<?php echo __ROOT__;?>";
		//最小入库时间
		var min_read_time = <?php echo MIN_READ_TIME;?>;
		//在线时间差
		var online_time_cha = <?php echo ONLINE_TIME;?>;
		
		$(document).ready(function(){
			$(".right").click(function(){
				if($(".right-active").length){
					$(".right").animate({right:'-2.3em',opacity:'1'});
					$(".right").removeClass("right-active");
				} else {
					$(".right").animate({right:'0em',opacity:'0.8'});
					$(".right").addClass("right-active");
				}
			});
    		$(".replyimg").click(function(){
    			var id=$(this).attr('id');
    			document.getElementById("father_id").value=id;
    			$("#dbox").hide();
    			$("#rbox").show();
    			$("#discuss_reply").focus();
    		});	
			$(".preandnext div").click(function(){
    			var id=$(this).attr('id');
    			$("ul[id="+id+"]").toggle();
				$(".preandnext div ul[id!="+id+"]").hide();
    		});	
		});
	</script>
	<script src="./js/artdetail.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>

 <div class="header">
        <h2><?php echo WEBSITE_NAME;?></h2>
    </div>
<div class="detail_top"></div>

<div class="right">
<ul>
<?php
	$art_type = array(1=>'文章',2=>'图文',3=>'视频');
	$sql="select * from article_info where art_class_id='{$current_curriculum_id}'";
	$result=mysql_query($sql);
	while($row=mysql_fetch_array($result)){
	    if ($row['art_id'] == $current_art_id) {
	        echo "<li class='block{$row['art_type']}'><a class='active' href='javascript:void(0);'>{$art_type[$row['art_type']]}</a></li>";
	    } else {
	        echo "<li class='block{$row['art_type']}'><a href='./artdetail.php?art_id={$row['art_id']}'>{$art_type[$row['art_type']]}</a></li>";
	    }
		
	}
?>
</ul>
</div>


    <div class="container">
    	<div class="art-header" >
			<h3><?php echo $article['art_title']; ?></h3>
			<p  style="display:none;">
				<span>时间：<?php echo $article['publication_time']; ?></span>
				<span>作者：<?php echo $article['author'] ?></span>
			</p>
		</div>
		<div class="art-content">
			<?php 
	       		echo $article['text'];
	       	?>
		</div>
        <div class="preandnext">
        <span style="">
        		<?php
        			$pre_curriculum = getPreCurriculum($current_curriculum_id, $curriculumids);
        			if ($pre_curriculum != false) {
      					echo "<div id='pre'>";
						echo "<span>上一知识点</span><ul id='pre' style='display:none;'>";			
						//$art_type = array(1=>'文章',2=>'图文',3=>'视频');
	$sql="select * from article_info where art_class_id='{$pre_curriculum}'";
	$result=mysql_query($sql);
	while($row=mysql_fetch_array($result)){
	 echo "<li><a class='block{$row['art_type']}' href='./artdetail.php?art_id={$row['art_id']}'>{$art_type[$row['art_type']]}</a></li>";	
	}								
	echo "</ul></div>";
}	
        		?>
        		</span>
         
         <span style="">
        		<?php
        			$next_curriculum = getNextCurriculum($current_curriculum_id, $curriculumids);
        			if ($next_curriculum != false) {
        				echo "<div id='next'>";
						echo "<span>下一知识点</span><ul id='next' style='display:none;'>";
						
						//$art_type = array(1=>'文章',2=>'图文',3=>'视频');
	$sql="select * from article_info where art_class_id='{$next_curriculum}'";
	$result=mysql_query($sql);
	while($row=mysql_fetch_array($result)){

	        echo "<li><a class='block{$row['art_type']}' href='./artdetail.php?art_id={$row['art_id']}'>{$art_type[$row['art_type']]}</a></li>";

		
	}
										
						echo "</ul></div>";
        			}else{
						echo "<a href='practice.php?unit_id={$current_unit_id}'><span style='font-size:0.8em;'>选择题测试</span></a>";
						}
        		?>
        		</span>
        </div>
        
        
        
    </div>



<div class="discuss">
                <h4>讨论区</h4>
                <ul>
                <?php
				$sql="select discuss.*,student.student_name from discuss,student where discuss.curriculum_id='{$current_unit_id}' and student.student_id=discuss.student_id ORDER BY time DESC";
				$result=mysql_query($sql);
				$i=mysql_num_rows($result);
				$floor=array();
				while($row=mysql_fetch_array($result)){
					$floor[$row['id']]=$i;
					$i--;
					}
					if(mysql_num_rows($result)>0){
				mysql_data_seek($result,0);}
				while($row=mysql_fetch_array($result)){
					if($_SESSION ['student_id']==$row['student_id']){
							$del="<a class='del' href='Control/MemberControl.php?action=delectdiscuss&id={$row['id']}'>删除</a>";
							$replyimg="";
							}else{
							$del="";
							$replyimg="<a class='replyimg' id='{$row['id']}' href='#rbox'></a>";
							}
					if($row['father_id']==0){
						echo "<li id='d1'><h5><span class='floor'>#{$floor[$row['id']]}</span>&nbsp;&nbsp;{$row['student_name']}<span  class='time'>{$row['time']}</span>{$replyimg}{$del}</h5>{$row['content']}</li>";
						}elseif($row['father_id']!=0){
							$fsql="select discuss.*,student.student_name from discuss,student where discuss.id='{$row['father_id']}' and student.student_id=discuss.student_id";
							$fresult=mysql_query($fsql);
							if($frow=mysql_fetch_array($fresult)){
								if($frow['curriculum_id']==0){
							    $fcontent="<p style='color:red;'>该用户已删除评论<p>";
								}else $fcontent=$frow['content'];
								echo "<li id='d1'><h5><span class='floor'>#{$floor[$row['id']]}</span>&nbsp;&nbsp;{$row['student_name']}<span class='reply'>回复</span>{$frow['student_name']}<span class='time'>{$row['time']}</span>{$replyimg}{$del}</h5>{$row['content']}";
								echo "<div id='d2'><h5><span class='floor'>#{$floor[$frow['id']]}</span>&nbsp;&nbsp;{$frow['student_name']}<span  class='time'>{$frow['time']}</span></h5>{$fcontent}</div></li>";
								}
							
							}
					}
				?>
             </ul>  
             <div id="dbox">
             <form action="Control/MemberControl.php?action=discuss&curriculum_id=<?php echo $current_unit_id; ?> " method="post">
             <input type="text" id="discuss_content" name="discuss_content"  /><button type="submit">发 送</button>
             </form>
             </div>
             <div id="rbox" style="display:none;">
             <form action="Control/MemberControl.php?action=reply&curriculum_id=<?php echo $current_unit_id; ?> " method="post">
             <input type="hidden" id="father_id" name="father_id" />
             <input type="text" id="discuss_reply" name="discuss_reply"  /><button type="submit">发送回复</button>
             </form>
             </div>
        </div>

</body>
</html>