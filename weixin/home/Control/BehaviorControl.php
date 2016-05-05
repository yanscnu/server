<?php
	session_start();
	setcookie('PHPSESSID', session_id(), time()+1800, '/');

	$document_root = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']),'/');
	require_once($document_root.'/weixin/config/init.php');
	$action = isset($_GET['action'])?$_GET['action']:null;
	if($action != null){
		if(function_exists($action)){
			$action();
		}else{
			exit('异常访问！参数有误！');
		}
	}else{
	}
	
	
//	function readtime(){
//		if(!isAjax()){
//			exit('异常访问！');
//		}
//		if (!session_id()) {
//			session_start();
//		}
//		$student_id = $_SESSION['student_id'];
//		$art_id = $_POST['art_id'];
//		$begin_time = $_POST['begin_time'];
//		$read_time = time() - $begin_time;
//		if(!isset($_POST['rb_id'])){
//			$sql = "insert into `read_behavior`(`student_id`, `art_id`, `begin_time`, `read_time`) values
//					({$student_id}, {$art_id}, {$begin_time}, {$read_time})";
//			mysql_query($sql);
//			$rb_id = mysql_insert_id();
//		}else {
//			$rb_id = $_POST['rb_id'];
//			$sql = "update `read_behavior` set `read_time` = {$read_time} where `rb_id`={$rb_id}";
//			mysql_query($sql);
//		}
//		exit(json_encode(array('rb_id'=>$rb_id)));
//	}

	function readtime(){
		if(!isAjax()){
			exit('异常访问！');
		}
		$student_id = $_SESSION['student_id'];
		$art_id = $_POST['art_id'];
		$curriculum_id = $_POST['curriculum_id'];
		$unit_id = $_POST['unit_id'];
		$session_id = session_id();
		$read_time = $_POST['read_time'];
		if($read_time < MIN_READ_TIME){	//小于不进行记录
			exit(json_encode(array('status'=>FALSE)));
		}
		/**
		 * 处理课时学习表
		 */
		$query = "SELECT `cl_id` from `curriculum_learn` WHERE `student_id`={$student_id}
					AND `curriculum_id`={$curriculum_id} AND `session_id`='{$session_id}'";
		$result = mysql_query($query) or die(mysql_error());
		if (mysql_num_rows($result) <= 0) {
			//插入数据到‘curriculum_learn’表
			$query = "INSERT INTO `curriculum_learn`
						(`student_id`, `curriculum_id`, `unit_id`,`session_id`, `begin_time`, `learn_time`) VALUES
						({$student_id}, {$curriculum_id}, {$unit_id}, '{$session_id}', NOW(), $read_time)";
			mysql_query($query) or die(mysql_error());
		} else {
			//更新数据
			$row = mysql_fetch_assoc($result);
			$query = "UPDATE `curriculum_learn` SET `learn_time`=`learn_time`+{$read_time} 
						WHERE `cl_id`={$row['cl_id']}";
			mysql_query($query) or die(mysql_error());
		}
		/**
		 * 处理文章阅读表
		 */
		$query = "SELECT `rb_id` FROM `read_behavior` WHERE 
					`student_id`={$student_id} AND `art_id`={$art_id}";
		$result = mysql_query($query) or die(mysql_error());
		if (mysql_num_rows($result) <= 0) {
			$query = "insert into `read_behavior`(`student_id`, `art_id`, `read_count`) values
				({$student_id}, {$art_id}, 1)";
			mysql_query($query) or die(mysql_error());
		} else {
			$row = mysql_fetch_assoc($result);
			$query = "UPDATE `read_behavior` SET `read_count`=`read_count`+1 WHERE
						`rb_id`={$row['rb_id']}";
			mysql_query($query) or die(mysql_error());
		}
		exit(json_encode(array('status'=>true)));
	}
	
	
	/**
	 * 单元访问
	 */
	function unit_access(){
		if(!isAjax()){
			exit('异常访问！');
		}
// 		if (!session_id()) {
// 			session_start();
//			setcookie('PHPSESSID', session_id(), time()+600, '/');
// 		}
		$student_id = $_SESSION['student_id'];
		$unit_id = $_POST['unit_id'];
		$session_id = session_id();
		$sql = "SELECT `ul_id` from `unit_learn` WHERE `student_id`={$student_id}
					AND `unit_id`={$unit_id} AND `session_id`='{$session_id}'";
		$result = mysql_query($sql);
		if(mysql_num_rows($result) <= 0){
			$sql = "insert into `unit_learn`(`student_id`,`session_id`, `unit_id`, `begin_time`) 
					values({$student_id},'{$session_id}',{$unit_id}, NOW())";
			mysql_query($sql) or die(mysql_error());
		}else {
			//不需要更新
		}
		exit(json_encode(array('status'=>true)));
	}
	
	
	/**
	 * 学生习题提交
	 */
	function practiceSub() {
	    $post_str = serialize ( $_POST );
	    $unit_id = $_GET ['unit_id'];
	    $student_id = $_SESSION ['student_id'];
	    //查询当前的练习对应的主键id
	    $query = "SELECT `pid`,`answer_content` FROM `practice` WHERE `unit_id`={$unit_id} LIMIT 1";
	    $result = mysql_query($query) or die(mysql_error());
	    if (mysql_num_rows($result) <= 0) {
	        exit('异常访问');
	    }
	    $row = mysql_fetch_assoc($result);
	    $pid = $row['pid'];
	    $answer_content = $row['answer_content'];
	    //记录答题记录
	    $sql = "INSERT INTO `practice_record`(`student_id`,`pid`,`record_content`,`answer_time`)
	    values('{$student_id}' , '{$pid}' , '{$post_str}',NOW())";
	    mysql_query ( $sql ) or die(mysql_error());
	    if (mysql_affected_rows () > 0) {
	        $pr_id = mysql_insert_id();    //习题记录表主键id
	        if ($answer_content == '') {
	            show_message('提交成功，但习题暂时没有标准答案');
	        } else {
	            //标准答案
	            $answer_arr = unserialize ( $answer_content );
	            $answer_result = array ();	//记录答题的对错情况，答对记录为true,答错记录false,并记录错误的答案
	            $correct_count = 0;
	            foreach ( $answer_arr as $key => $value ) {
	                //答对
	                if ($value === $_POST [$key]) {
	                    $answer_result [$key] = true;
	                    $correct_count ++;
	                }
	                //答错
	                else {
	                    //多选情况
	                    if (is_array ( $value )) {
	                        $answer_result [$key] = array (
	                            FALSE,
	                            implode ( '', $value )
	                        );
	                    }
	                    //单选情况
	                    else {
	                        $answer_result [$key] = array (
	                            FALSE,
	                            $value
	                        );
	                    }
	                }
	            }
	            //序列化答题记录（入库），出库时要进行反序列化
	            $answer_result_str = serialize ( $answer_result );
	            $count = count ( $answer_arr );
	            //正确率
	            $correct_rate = round ( $correct_count / $count, 2 );
	            $sql = "update `practice_record` set `answer_result` = '$answer_result_str', `correct_rate`={$correct_rate}
	                       where `pr_id`={$pr_id}";
	            mysql_query ( $sql ) or die(mysql_error());
	            header ( "Location:".__ROOT__."home/practiceresult.php?pid={$pid}&pr_id={$pr_id}" );
	        }
	    } else {
	        show_message('习题提交失败', true);
	    }
	}
	
	function test() {
		$dir = ROOT_PATH.'home/test';
		if (!is_dir($dir)) {
			mkdir($dir);
		}
		file_put_contents($dir.'/'.time().'.txt', date('Y-m-d H:i:s'));
		exit(json_encode(array('status'=>true)));
	}
?>
