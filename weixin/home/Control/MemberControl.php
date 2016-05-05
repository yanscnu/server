<?php
session_start();
setcookie('PHPSESSID', session_id(), time()+1800, '/');

$document_root = rtrim ( str_replace ( '\\', '/', $_SERVER ['DOCUMENT_ROOT'] ), '/' );
require_once ($document_root . '/weixin/config/init.php');
$action = isset ( $_GET ['action'] ) ? $_GET ['action'] : null;
if ($action != null) {
	if (function_exists ( $action )) {
		$action ();
	} else {
		exit ( '异常访问！参数有误！' );
	}
} else {
}

/**
 * 跳转到登录页面
 */
function toLoginPage() {
	//HTTP_REFERER
	//引导用户代理到当前页的前一页的地址（如果存在）。由 user agent 设置决定。并不是所有的用户代理都会设置该项，
	//有的还提供了修改 HTTP_REFERER 的功能。简言之，该值并不可信。
// 	if (isset($_SERVER['HTTP_REFERER'])) {
// 		$_SESSION['backUrl'] = $_SERVER['HTTP_REFERER'];
// 	}else {
		$_SESSION['backUrl'] = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
// 	}
	header ( "Location:".__ROOT__."home/login.php");
	exit();
}

/**
 * 注册
 */
function register() {
	$sql = "select * from student where student_name='{$_POST['student_name']}'";
	$result_register = mysql_query ( $sql );
	$error_arr = array ();
	//验证用户名
	if (mysql_num_rows ( $result_register ) > 0) {
		$error_arr ['err_student_name'] = urlencode('用户名已存在');
	} else {
		if (is_array($student_name = check_student_name($_POST['student_name']))) {
			$error_arr['err_student_name'] = urlencode(implode(',', $student_name));
		}
	}
	//验证密码
	if (is_array($student_psw = check_password($_POST['student_psw'], $_POST['repassword']))) {
		$error_arr['err_pass'] = urlencode(implode(',', $student_psw));
	}
	//验证验证码
	if (strtoupper($_POST['checkcode']) != $_SESSION ['checkcode']) {
		$error_arr['err_code'] = urlencode('验证码错误');
	}
	//有错误，则回传错误信息
	if (count ( $error_arr ) > 0) {
		$error_arr ['student_name'] = urlencode($_POST['student_name']);
		header ( "Location:" . __ROOT__ . "home/register.php?" . http_build_query ( $error_arr ) );
		exit ();
	}
	//没有错误，插入注册信息到数据库
	else {
		$sql = "INSERT INTO `doers`.`student` ( `student_name`, `student_psw`) VALUES ( '{$student_name}', '{$student_psw}')";
		mysql_query ( $sql ) or die ( mysql_error () );
		show_message ( "注册成功<br/><a href='" . __ROOT__ . "home/login.php'>前往登录页面</a>", true );
	}
	exit;
}

/**
 * 验证用户名格式是否正确，验证通过返回转义后的字符串
 * @param string $student_name 用户名
 * @param number $min_len 最小长度
 * @param number $max_len 最大长度
 * @return mixed 错误信息数组或转义后的字符串
 */
function check_student_name($student_name, $min_len=3, $max_len=20) {
	$len = mb_strlen($student_name, 'utf-8');
	$errors = array();
	if ($len < $min_len || $len > $max_len) {
		$errors[] = '长度不正确';
	}
	//只能包含数字、英文、下划线、汉字
	$pattern = "/^[\x{4e00}-\x{9fa5}\w][\x{4e00}-\x{9fa5}\w]*[\x{4e00}-\x{9fa5}\w]$/u";
	if (!preg_match($pattern, $student_name)) {
		$errors[] = '只能包含字母、数字、下划线、汉字';
	}
	if (count($errors) > 0) {
		return $errors;
	}
	return mysql_real_escape_string($student_name);
}

/**
 * 验证密码格式是否正确，验证通过则返回转义后的字符串
 * @param unknown $student_psw
 * @param unknown $repassword
 * @param number $min_len
 * @param number $max_len
 * @return mixed 错误信息数组或转义后的字符串
 */
function check_password($student_psw, $repassword, $min_len=6, $max_len=20) {
	$errors = array();
	if ($student_psw != $repassword) {
		$errors[] = '密码不一致';
	}
	/**
	 * 由于密码已经在客户端加密，下面不需要进行判断
	 */
// 	$len = mb_strlen($student_psw, 'utf-8');
// 	if ($len < $min_len || $len > $max_len) {
// 		$errors[] = '长度不正确';
// 	}
// 	$pattern = "/^[\w][\w]*[\w]$/";
// 	if (!preg_match($pattern, $student_psw)) {
// 		$errors[] = '只能包含字母、数字、下划线';
// 	}
	if (count($errors) > 0) {
		return $errors;
	}
	return mysql_real_escape_string($student_psw);
}


/**
 * 登录
 */
function login() {
	//对表单数据进行转义，避免sql注入风险
	$student_name = isset ( $_POST ['student_name'] ) ? addslashes ( $_POST ['student_name'] ) : '';
	$student_psw = isset ( $_POST ['student_psw'] ) ? addslashes ( $_POST ['student_psw'] ) : '';
	$query = "select student_id from student where student_name='$student_name' and student_psw='$student_psw'";
	$result = mysql_query ( $query )  or die(mysql_error());
	if (mysql_num_rows ( $result ) <= 0) {
		$errors = array();
		$errors['err_name_pass'] = urlencode('用户名或密码错误');
		$errors['student_name'] = $student_name;
		header ( "Location:".__ROOT__."home/login.php?".http_build_query($errors));
		exit ();
	} else {
		$row = mysql_fetch_assoc ( $result );
		// 更新登录次数
		$sql = "update `student` set `login_count` = `login_count`+1 where `student_id`={$row['student_id']}";
		mysql_query ( $sql );
		$_SESSION ['student_id'] = $row ['student_id'];
		record_login ();
		if (isset($_SESSION['backUrl'])) {
			$backUrl = $_SESSION['backUrl'];
			unset($_SESSION['backUrl']);
			header ( "Location:".$backUrl);
		}else {
			header ( "Location:".__ROOT__."index.php" );
		}
		exit();
	}
}

/**
 * 记录用户登录到数据库表
 */
function record_login() {
	$session_id = session_id ();
	$student_id = $_SESSION ['student_id'];
	$login_time = time ();
	$sql = "insert into `login_record`(`session_id`,`student_id`,`login_time`) values('{$session_id}',{$student_id},{$login_time})";
	mysql_query ( $sql ) or die(mysql_error());
	setcookie ( 'login_time', $login_time, 0, '/' );
	setcookie ( 'online_time', 0, 0, '/' );
}
/**
 * 更新在线时间
 */
function update_onlinetime() {
	if (! isAjax ()) {
		exit ( '异常访问！' );
	}
	$session_id = session_id ();
	$student_id = $_SESSION ['student_id'];
	$login_time = $_COOKIE ['login_time'];
	$now = time ();
	$online_time = $now - $login_time;
	$sql = "update `login_record` set `online_time` = {$online_time} where 
				`session_id`='{$session_id}' and `student_id`={$student_id}";
	mysql_query ( $sql );
	setcookie ( 'online_time', $online_time, 0, '/' );
	exit ( json_encode ( array (
			'status' => true 
	) ) );
}

/**
 * 判断是否登录
 * 
 * @return boolean
 */
function isLogin() {
	if (isset ( $_SESSION ['student_id'] )) {
		return true;
	} else {
		return false;
	}
}


// 讨论区回复 get:father_id,curriculum_id post:discuss_reply
function reply() {
	//$father_id = $_GET ['father_id'];
	$father_id = isset ( $_POST ['father_id'] ) ? addslashes ( $_POST ['father_id'] ) : '';
	$discuss_reply = isset ( $_POST ['discuss_reply'] ) ? addslashes ( $_POST ['discuss_reply'] ) : '';
	$curriculum_id = $_GET ['curriculum_id'];
	$student_id = $_SESSION ['student_id'];
	$sql = "INSERT INTO `doers`.`discuss` (`student_id`, `curriculum_id`, `father_id`, `content`, `time`) VALUES ('{$student_id}', '{$curriculum_id}', '{$father_id}', '{$discuss_reply}', now());";
	mysql_query ( $sql );
	header ( "location:" . getenv ( 'HTTP_REFERER' ) );
}
/**
 * 删除
 */
function delectdiscuss(){
	$discuss_id=$_GET['id'];
	$student_id = $_SESSION ['student_id'];
	
	$sql="UPDATE `doers`.`discuss` SET   `curriculum_id`='0'  WHERE `id`='{$discuss_id}' and student_id='{$student_id}';";
	mysql_query ( $sql );
	header ( "location:" . getenv ( 'HTTP_REFERER' ) );
	}

/**
 * 讨论区 get:curriculum_id post:discuss_content
 */
function discuss() {
	$curriculum_id = $_GET ['curriculum_id'];
	$discuss_content = isset ( $_POST ['discuss_content'] ) ? addslashes ( $_POST ['discuss_content'] ) : '';
	$student_id = $_SESSION ['student_id'];
	$sql = "INSERT INTO `doers`.`discuss` (`student_id`, `curriculum_id`, `father_id`, `content`, `time`) VALUES ('{$student_id}', '{$curriculum_id}', '0', '{$discuss_content}', now());";
	mysql_query ( $sql );
	header ( "location:" . getenv ( 'HTTP_REFERER' ) );
}

function questionnaire() {
    $student_id = $_SESSION['student_id'];
    $data['student_sex'] = isset($_POST['sex'])?mysql_real_escape_string($_POST['sex']):null;
    $data['student_degree'] = isset($_POST['degree'])?mysql_real_escape_string($_POST['degree']):null;
    $data['student_age'] = isset($_POST['age'])?(int)mysql_real_escape_string($_POST['age']):null;
    $data['student_q4'] = isset($_POST['q4'])?mysql_real_escape_string($_POST['q4']):null;
    $data['student_q5'] = isset($_POST['q5'])?mysql_real_escape_string($_POST['q5']):null;
    $data['student_q6'] = isset($_POST['q6'])?mysql_real_escape_string($_POST['q6']):null;
    $data['student_q7'] = isset($_POST['q7'])?mysql_real_escape_string($_POST['q7']):null;
    
    foreach ($data as $value){
        if ($value == '' || $value == null) {
            echo "<script>alert('所有选项均不能空！');history.go(-1);</script>";
            exit();
        }
    }
    
    $query = "UPDATE `student` SET `student_sex`='{$data['student_sex']}', `student_degree`='{$data['student_degree']}' ,
                `student_age`={$data['student_age']}, `student_q4`='{$data['student_q4']}', `student_q5`='{$data['student_q5']}'
                , `student_q6`='{$data['student_q6']}', `student_q7`='{$data['student_q7']}' WHERE `student_id`={$student_id}";
    mysql_query($query) or die(mysql_error());
    if (mysql_affected_rows() > 0) {
        show_message('问卷提交成功',true);
    } else {
        show_message('问卷提交失败', true);
    }
}

function evaluate() {
    $unit_id = $_GET['unit_id'];
    $student_id = $_SESSION['student_id'];
    $data['suggestion'] = isset($_POST['suggestion'])?mysql_real_escape_string($_POST['suggestion']):'';
    $data['learn_resource'] = isset($_POST['learn_resource'])?mysql_real_escape_string($_POST['learn_resource']):'';
    $data['master_degree'] = isset($_POST['master_degree'])?mysql_real_escape_string($_POST['master_degree']):'';
    $i = 0;
    foreach ($data as $value) {
        if ($value != '') {
            $i++;
        }
    }
    if ($i == 0) {
        echo "<script>alert('所有选项均为空，不能提交！');history.go(-1);</script>";
        exit();
    }
    
    $query = "INSERT INTO `evaluate_record`(`student_id`,`unit_id`,`suggestion`,`learn_resource`,`master_degree`) 
                VALUES({$student_id},{$unit_id},'{$data['suggestion']}','{$data['learn_resource']}','{$data['master_degree']}')";
    mysql_query($query) or die(mysql_error());
    if (mysql_affected_rows() > 0) {
        show_message('评价提交成功');
    } else {
        show_message('评价提交失败');
    }
}

?>