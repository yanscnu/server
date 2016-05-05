<?php
	
	/**
	 * 判断是否是Ajax请求
	 */
	function isAjax(){
	  if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	    return true;
	  }else{
	    return false;
	  }
	}
	
	/**
	 * mysql智能查询方法，以数组形式返回查询到的数据
	 * @param string $query 查询语句
	 * @param int $result_type 取值：MYSQL_ASSOC, MYSQL_NUM, and MYSQL_BOTH
	 * @param string $show_error 是否显示sql错误
	 * @return boolean|array
	 */
	function mysql_smart_query($query, $result_type = MYSQL_ASSOC, $show_error = null) {
	    if ($show_error===null) {
	        if (defined('SHOW_SQL_ERROR')) {
	            $show_error = SHOW_SQL_ERROR;
	        } else {
	            $show_error = false;
	        }
	    } elseif($show_error===true || $show_error===false){
	        ;
	    } else {
	        $show_error = false;
	    }
	    if ($show_error) {
	        $result = mysql_query($query) or exit('mysql执行错误：'.mysql_error());
	    } else {
	        $result = mysql_query($query);
	    }
	    if (mysql_num_rows($result) <= 0) {
	        return false;
	    }
	    $rows = array();
	    while (($row = mysql_fetch_array($result, $result_type)) != false) {
	        $rows[] = $row;
	    }
	    return $rows;
	}
	
	/**
	 * 返回一个路径的标准形式
	 * @param string $path 传入的路径参数
	 * @return string 兼容的路径模式，切后面不带‘/’
	 */
	function toStandardPath($path) {
		$path = str_replace('\\', '/', $path);
		rtrim($path, '/');
		return $path;
	}
	
	/**
	 * 删除文件
	 * @param string $filePath 文件路径
	 */
	function delFile($filePath){
		if(file_exists($filePath)){
			unlink($filePath);
		}
	}
	
	/**
	 * 输出信息，因为这是完整的html页面，建议调用此函数后终止程序执行，
	 * 看错误严重情况而定,可传入可选参数is_exit,默认为不终止程序执行
	 * @param unknown $message
	 */
	function show_message($message, $is_exit=false) {
		//替换其中的php变量或常量
		$query_data = array('message'=>urlencode($message));
		header('Location:'.__ROOT__.'home/show_message.php?'.http_build_query($query_data));
		if ($is_exit) {
			exit();
		} 
	}
	
	
	/**
	 * 返回单元下的课时id，单元下没有课时时返回false，有时返回id集合
	 * @param int $unit_id 单元id
	 * @return boolean|array
	 */
	function curriculumidsInUnit($unit_id) {
		$sql = "select `art_class_id` from `art_class` where `art_class_father_id`={$unit_id} order by art_class_sort asc";
		$result = mysql_query($sql);
		if (mysql_num_rows($result) <= 0) {
			return false;
		}
		$curriculumids = array();
		while ($row = mysql_fetch_assoc($result)) {
			$curriculumids[] = $row['art_class_id'];
		}
		return $curriculumids;
	}
	
	/**
	 * 返回课时下的文章id，课程下没有文章时返回false，有时返回id集合
	 * @param int $curriculum_id 课时id
	 * @return boolean|array
	 */
	function artidsInCurriculum($curriculum_id) {
		$sql = "select `art_id`,`art_type` from article_info where art_class_id={$curriculum_id} and state='1' order by art_sort";
		$result = mysql_query($sql);
		if (mysql_num_rows($result) <= 0) {		//第一课时下面没有文章
			return false;
		}
		$art_ids = array();
		while ($row = mysql_fetch_assoc($result)) {
			$art_ids[$row['art_id']] = $row['art_type'];
		}
		return $art_ids;
	}
	
	/**
	 * 返回父id
	 * @param int $childId id
	 * @param string $childType 类型，有‘article’、‘curriculum’两种选择
	 * @return int 父id
	 */
	function parentId($childId, $childType) {
		switch ($childType) {
			case 'article':
				$sql = "select `art_class_id` from `article_info` where `art_id`={$childId}";
				break;
			case 'curriculum':
				$sql = "select `art_class_father_id` from `art_class` where `art_class_id`={$childId}";
				break;
		}
		$result = mysql_query($sql);
		$row = mysql_fetch_row($result);
		$parent_id = $row[0];
		return $parent_id;
	}
	
	
	/**
	 * 根据文章id,查找文章的信息
	 * 文章不存在时返回false
	 * @param unknown $art_id
	 * @return boolean|array
	 */
	function artInfo($art_id){
		$sql = "select * from `article_info` where `art_id`={$art_id}";
		$result = mysql_query($sql);
		if (mysql_num_rows($result) <= 0) {
			return false;
		}
		return mysql_fetch_assoc($result);
	}
	
	/**
	 * 根据课时id,查询课时的信息
	 * 课时不存在时，返回false
	 * @param unknown $curriculum_id 课时id
	 * @return boolean|array
	 */
	function artClassInfo($art_class_id) {
		$sql = "select * from `art_class` where `art_class_id`={$art_class_id}";
		$result = mysql_query($sql);
		if (mysql_num_rows($result) <= 0) {
			return false;
		}
		return mysql_fetch_assoc($result);
	}
	
	/**
	 * 获取当前课时的上一课时id，没有就返回false
	 * @param int $current_curriculum_id 课时id
	 * @param int $curriculumids 课时列表（已根据sort属性排序）
	 * @return boolean|int
	 */
	function getPreCurriculum($current_curriculum_id, $curriculumids) {
		$len = count($curriculumids);
		for ($i = 0; $i < $len; $i++) {
			if ($curriculumids[$i] == $current_curriculum_id) {
				if ($i == 0) {
					return false;
				}
				return $curriculumids[$i-1];
			}
		}
	}
	
	/**
	 * 获取当前课时的下一课时id，没有就返回false
	 * @param int $current_curriculum_id 课时id
	 * @param int $curriculumids 课时列表（已根据sort属性排序）
	 * @return boolean|int
	 */
	function getNextCurriculum($current_curriculum_id, $curriculumids) {
		$len = count($curriculumids);
		for ($i = 0; $i < $len; $i++) {
			if ($curriculumids[$i] == $current_curriculum_id) {
				if ($i == $len-1) {
					return false;
				}
				return $curriculumids[$i+1];
			}
		}
	}

	/**
	 * 生成单元列表
	 * @return boolean|array 格式：array('art_class_id'=>'art_class_name',...)
	 */
	function getUnitList() {
		$query = "SELECT `art_class_id`, `art_class_name` FROM `art_class` WHERE `art_class_father_id`=0 ORDER BY `art_class_sort`";
		$result = mysql_query($query) or die(mysql_error());
		if (mysql_num_rows($result) < 0) {
			return false;
		}
		$units = array();	//单元列表
		while ($row = mysql_fetch_assoc($result)){
			$units[$row['art_class_id']] = $row['art_class_name'];
		}
		return $units;
	}
	
	/**
	 * 生成单元的学习时间
	 * 没有数据返回false
	 * 有时间返回数组  数组的形式(键名：单元id,键值:学习时间)
	 * @return boolean|array
	 */
	function getUnitLearnTime($student_id) {
		$query = "SELECT `unit_id`,SUM(`learn_time`) `learn_time` FROM `curriculum_learn` WHERE `student_id`={$student_id} GROUP BY `unit_id`";
		$result = mysql_query($query) or die(mysql_error());
		if (mysql_num_rows($result) <= 0) {
			return false;
		}
		$unit_learn_time = array();
		while ($row = mysql_fetch_assoc($result)) {
			$unit_learn_time[$row['unit_id']] = $row['learn_time'];
		}
		return $unit_learn_time;
	}
	
	/**
	 * 获取单元或课时的数量
	 * @param string $type 有两种取值‘curriculum’，‘unit’
	 * @return boolean|number 
	 */
	function getCourseCount($type, $unit_id=null) {
	    if ($type == 'curriculum') {
	        if (!is_null($unit_id)) {
	            $query = "SELECT COUNT(*) FROM `art_class` WHERE `art_class_father_id`={$unit_id}";
	        } else {
	            $query = "SELECT COUNT(*) FROM `art_class` WHERE `art_class_father_id`!=0";
	        }
	    } elseif ($type == 'unit') {
	        $query = "SELECT COUNT(*) FROM `art_class` WHERE `art_class_father_id`=0";
	    } else {
	        return false;
	    }
	    $result = mysql_query($query) or die(mysql_error());
	    $row = mysql_fetch_row($result);
	    return (int)$row[0];
	}
	
	/**
	 * 单元下的课时是否已经全部学习
	 * 学完返回true
	 * 未学完返回flase
	 * @param int $student_id
	 * @param int $unit_id
	 */
	function isLearnAllCurriculum($student_id, $unit_id) {
	    $query = "SELECT `curriculum_id` FROM `curriculum_learn` WHERE `student_id`={$student_id} 
	               AND `unit_id`={$unit_id} GROUP BY `curriculum_id`";
	    $rows = mysql_smart_query($query);
	    $count = count($rows);
	    $curriculum_count = getCourseCount('curriculum', $unit_id);
	    if ($count < $curriculum_count) {
	        return false;
	    }
	    return true;
	}
	
	/**
	 * 获取课时下的最后一篇文章的id
	 * @param int $curriculum_id 课时id
	 * @return int 最后一篇文章的id
	 */
	function getLastArticle($curriculum_id) {
	    $query = "SELECT `art_id` FROM `article_info` WHERE `art_class_id`={$curriculum_id} ORDER BY `art_sort` DESC LIMIT 1";
	    $rows = mysql_smart_query($query);
	    return $rows[0]['art_id'];
	}
	
	/**
	 * 是否已经学习某个单元
	 * 已经学习返回true,没有学习返回false
	 * @param int $student_id 学生id
	 * @param int $unit_id 单元id
	 * @return boolean 
	 */
	function isLearnUnit($student_id, $unit_id) {
	    $query = "SELECT COUNT(*) `sum` FROM `curriculum_learn` WHERE `student_id`={$student_id} 
	       AND `unit_id`={$unit_id}";
	    $result = mysql_query($query) or die(mysql_error());
	    $row = mysql_fetch_assoc($result);
	    if ($row['sum'] == 0) {
	        return false;
	    }
	    return true;
	}
	
	/**
	 * 返回本周周一的时间戳
	 */
	function thisMonday(){
	    $current = time();
	    $weekday = date('w',$current);
	    if ($weekday == 0) {
	        $weekday = 7;
	    }
	    $i = $weekday - 1;
	    $moday_str = date('Y-m-d',($current - $i*86400));
	    return strtotime($moday_str);
	}