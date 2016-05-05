<?php
	require_once('./Control/MemberControl.php');
	if(isLogin() == false){
		toLoginPage();
	}
	$student_id = $_SESSION['student_id'];
	
	/*
	 * 修改需求 
	 * 在主页点击单元目录直接跳转到该单元第一课时的文章详细页面
	 */
	//传递过来的art_class_id对应某个单元或者某个课程
	
	header('Content-Type:text/html;charset=utf-8');
	if (isset($_GET['art_class_id'])) {
		if (isset($_GET['isunit']) && $_GET['isunit'] == 'true') {		//传进来的是单元ID的情况
			//当前单元id
			$current_unit_id = $_GET['art_class_id'];
			//$curriculumids 课时id列表
			if (!($curriculumids = curriculumidsInUnit($current_unit_id))) {
				show_message('单元下面没有课程' ,true);
			}
			//当前课时id
			$current_curriculum_id = $curriculumids[0];
			//文章id列表
			if (!($art_ids = artidsInCurriculum($current_curriculum_id))) {
				show_message('课时下没有文章', true);
			}
			//当前文章id
			$keys = array_keys($art_ids);
			$current_art_id = $keys[0];
		} 
		elseif (isset($_GET['iscurriculum']) && $_GET['iscurriculum'] == 'true') {	//传进来的是课程id情况
			//当前课时id
			$current_curriculum_id = $_GET['art_class_id'];
			//单元列表
			$current_unit_id = parentId($current_curriculum_id, 'curriculum');
			//课时id列表
			$curriculumids = curriculumidsInUnit($current_unit_id);
			//文章id列表
			if (!($art_ids = artidsInCurriculum($current_curriculum_id))) {
				show_message('课时下没有文章', true);
			}
			//当前文章id
			$keys = array_keys($art_ids);
			$current_art_id = $keys[0];
		}
	} 
// 	elseif(isset($_GET['art_id'])) {	//传递进来的是文章的id
// 		//当前文章id
// 		$current_art_id = $_GET['art_id'];
// 		//当前课时id
// 		$current_curriculum_id = parentId($current_art_id, 'article');
// 		//当前单元id
// 		$current_unit_id = parentId($current_curriculum_id, 'curriculum');
// 		//课时id列表
// 		$curriculumids = curriculumidsInUnit($current_unit_id);
// 		//文章id列表
// 		$art_ids = artidsInCurriculum($current_curriculum_id);
// 	}

	//课时的内容
	$curriculum = artClassInfo($current_curriculum_id);
	if ($curriculum == false) {
		show_message('课时不存在', true);
	}
//单元的内容	
	$unit = artClassInfo($current_unit_id);
	
//上一课
$pre=$curriculum['art_class_sort']-1;
$next=$curriculum['art_class_sort']+1;
	
	
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
	<link rel="stylesheet" type="text/css" href="./css/curriculum.css" />
	<script src="../include/js/jquery-1.5.2.min.js"></script>
	<script src="./js/common.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		var project_root = "<?php echo __ROOT__;?>";
		//在线时间差
		var online_time_cha = <?php echo ONLINE_TIME;?>;

		var evaluate_error = "你还没完成所有课时的学习，不能做评价";

		var practice_error = "你还没完成所有课时的学习，不能做练习";
		
	</script>
</head>
<body>

	
	
    <div class="header">
        <h2><?php echo WEBSITE_NAME;?></h2>
    </div>
    <div class="container">
        <div class="brief">
            <h3><?php echo $unit['art_class_name'] ?></h3>
            <div class="sub">
                <h4 id="introduce">介绍</h4>
                <div>
                	<span><?php echo nl2br($unit['art_class_brief']);?></span>
                </div>
            </div>
            <div class="sub">
                <h4 id="target">目标</h4>
                <div>
                    <span><?php echo nl2br($unit['art_class_goal']);?></span>
                </div>
            </div>
        </div>
        <div class="art-list">
        	<?php
        		$art_type = array(1=>'文章',2=>'图文',3=>'视频');
	        	$i = 1;
	        	foreach ($art_ids as $key=>$value) {
	        		if ($current_art_id == $key) {
	        			echo "<a href='./artdetail.php?art_id={$key}' class='block{$i}'>{$art_type[$value]}</a>";
	        		} else {
	        			echo "<a href='./artdetail.php?art_id={$key}' class='block{$i}'>{$art_type[$value]}</a>";
	        		}
	        		$i++;
	        	}
	        ?>
        </div>
        <div class="curriculum_page" style="margin:0px auto; text-align:center; display:none;">
      
        		<span style="">
        		<?php
        			$pre_curriculum = getPreCurriculum($current_curriculum_id, $curriculumids);
        			if ($pre_curriculum != false) {
        				echo "<a href='curriculum.php?art_class_id={$pre_curriculum}&iscurriculum=true'>第{$pre}课时</a>";
        			}
        		?>
        		</span>
                <span style=""><a href='../index.php'>返回目录</a></span>
        		<span style="">
        		<?php
        			$next_curriculum = getNextCurriculum($current_curriculum_id, $curriculumids);
        			if ($next_curriculum != false) {
        				echo "<a href='curriculum.php?art_class_id={$next_curriculum}&iscurriculum=true'>第{$next}课时</a>";
        			}
        		?>
        		</span>
        	
        </div>
        <div class="practice">
            <div class="sub">
                <h4>
                    <?php 
                        if (isLearnAllCurriculum($student_id, $current_unit_id)) {
                            echo "<a href='practice.php?unit_id={$current_unit_id}'>习题</a>";
                        } else {
                            echo '<a href="javascript:alert(practice_error);">练习</a>';
                        }
                    ?>
                </h4>
                <div>
                    <p style="font-size:0.8em; padding:0 5px; margin:5px 0px;">在学习完每个单元的所有知识点之后可以进行知识检测，每个练习都是以选择题的形式进行。在进入练习之前需要完成所有的知识点学习，如果完成一次学习之后没有做到全对，可以选择重做，最多可以练习五次。</p>
                </div>
            </div>
        </div>
        <div class="discuss">
            <div class="sub">
                <h4>
                    <span>评价</span>
                    <?php 
//                         if (isLearnAllCurriculum($student_id, $current_unit_id)) {
//                             echo "<a href='artend.php?unit_id={$current_unit_id}'>评价</a>";
//                         } else {
//                             echo '<a href="javascript:alert(evaluate_error);">评价</a>';
//                         }
//                     ?>
                </h4>
                <div>
                    <p style="font-size:0.8em; padding:0 5px; margin:5px 0px;">在学习完每个单元的所有知识点之后可以对本单元进行评价，评价方式主要有两种，两道选择题和一道主观题，还可以对本单元的课程向教学老师和管理者提出你的宝贵建议。</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>