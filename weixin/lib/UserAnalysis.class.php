<?php
/**
 *
 * @author yan
 * @copyright 2016-03-28 
 *
 */
class UserAnalysis {
	
	protected static $studentId;
	
	/**
	 * 构造函数
	 * @param int $student_id 学生id
	 */
	function __construct($student_id) {
		self::$studentId  = $student_id;
	}
	
	/**
	 * 改变学生id
	 * @param int $student_id 学生id
	 */
	public static function setStudentId($student_id) {
		$this->studentId = $student_id;
	}
	
	
	/**
	 * 生成当前学生的指定单元学习路径数据，
	 * 用于前台highcharts插件显示
	 * @param int $unit_id 单元id
	 * @return bool|array false或生成的数据信息，false代表没有学习信息 
	 */
// 	public static function createLearnPathData($unit_id) {
// 		//从curriculum_learn表中取出学生课时学习记录（课时，课时学习时间）
// 		$student_id = self::$studentId;
// 		$query = "SELECT `learn_time`,`art_class_sort`,`art_class_name` FROM `curriculum_learn` INNER JOIN `art_class` WHERE
// 					`student_id`={$student_id} AND `unit_id`={$unit_id} AND 
// 					`curriculum_learn`.`curriculum_id`=`art_class`.`art_class_id` ORDER BY `begin_time` ASC";
// 		$result = mysql_query($query) or die(mysql_error());
// 		//没有数据，直接返回false
// 		if (mysql_num_rows($result) <= 0) {
// 			return false;
// 		}
// 		$data_arr = array();
// 		$curriculum = array();	//记录课时
// 		$art_class_names = array();
// 		while ($row = mysql_fetch_assoc($result)) {
// 			$time = round($row['learn_time']/60);
			
// 			$curriculum[] = $row['art_class_sort'];
			
// 			$count_values = array_count_values($curriculum);
// 			//首次学习
// 			if ($count_values[$row['art_class_sort']] == 1) {
// 				$a = array((int)$row['art_class_sort'], $time);
// 				$art_class_names[$row['art_class_sort']] = $row['art_class_name'];
// 				array_push($data_arr, $a);
// 			} 
// 			//二次学习
// 			else if ($count_values[$row['art_class_sort']] == 2) {
// 				$a = array('marker'=>array('symbol'=>'square','lineColor'=>null, 'lineWidth'=>2),
// 							'x'=>(int)$row['art_class_sort'], 'y'=>$time);
// 				array_push($data_arr, $a);
// 			} 
// 			//三次学习
// 			else if ($count_values[$row['art_class_sort']] == 3) {
// 				$a = array('marker'=>array('symbol'=>'triangle','lineColor'=>null, 'lineWidth'=>2),
// 							'x'=>(int)$row['art_class_sort'], 'y'=>$time);
// 				array_push($data_arr, $a);
// 			}
// 			//...之后的不管，不生成路径
// 			else {
// 				;
// 			}
// 		}
// 		$array = array('data'=>$data_arr,'art_class_names'=>$art_class_names);
// 		return $array;
// 	}

	
	public static function createLearnPathData($unit_id) {
	    $student_id = self::$studentId;
	    $query = "SELECT SUM(`learn_time`) `sum_time`,`art_class_sort`,`art_class_name` FROM `curriculum_learn` 
                    INNER JOIN `art_class` WHERE `student_id`={$student_id} AND `unit_id`={$unit_id} AND
	     			`curriculum_learn`.`curriculum_id`=`art_class`.`art_class_id` GROUP BY `art_class_sort` 
	               ORDER BY `art_class_sort` ASC";
	    $result = mysql_query($query) or die(mysql_error());
	    $curriculums = array();
	    $data = array();
	    while (($row = mysql_fetch_assoc($result)) != false) {
	        $curriculums[] = $row['art_class_name'];
	        $data[] = round($row['sum_time']/60,1);
	    }
	    $array = array('data'=>$data,'curriculums'=>$curriculums);
	    return $array;
	}

	
	
	/**
	 * 
	 * @param unknown $param
	 */
// 	function createUintLearnPathData() {
// 		$student_id = self::$studentId;
// 		$query = "SELECT `art_class_name`,`art_class_sort`,SUM(`learn_time`) `unit_learn_time`,`session_id`,`unit_id` FROM `curriculum_learn` cl 
// 					INNER JOIN `art_class` ac WHERE `student_id`={$student_id} AND cl.`unit_id`=ac.`art_class_id` 
// 					GROUP BY `session_id`,`unit_id` ORDER BY `begin_time` ASC";
// 		$result = mysql_query($query) or die(mysql_error());
// 		if (mysql_num_rows($result) <= 0) {
// 			return false;
// 		}
// 		$data_arr = array();
// 		$unit = array();
// 		$art_class_names = array();
// 		while ($row = mysql_fetch_assoc($result)) {
// 			$time = round($row['unit_learn_time']/60);
				
// 			$unit[] = $row['art_class_sort'];
				
// 			$count_values = array_count_values($unit);
// 			//首次学习
// 			if ($count_values[$row['art_class_sort']] == 1) {
// 				$a = array((int)$row['art_class_sort'], $time);
// 				$art_class_names[$row['art_class_sort']] = $row['art_class_name'];
// 				array_push($data_arr, $a);
// 			}
// 			//二次学习
// 			else if ($count_values[$row['art_class_sort']] == 2) {
// 				$a = array('marker'=>array('symbol'=>'square','lineColor'=>null, 'lineWidth'=>2),
// 						'x'=>(int)$row['art_class_sort'], 'y'=>$time);
// 				array_push($data_arr, $a);
// 			}
// 			//三次学习
// 			else if ($count_values[$row['art_class_sort']] == 3) {
// 				$a = array('marker'=>array('symbol'=>'triangle','lineColor'=>null, 'lineWidth'=>2),
// 						'x'=>(int)$row['art_class_sort'], 'y'=>$time);
// 				array_push($data_arr, $a);
// 			}
// 			//...之后的不管，不生成路径
// 			else {
// 				;
// 			}
// 		}
// 		$array = array('data'=>$data_arr,'art_class_names'=>$art_class_names);
// 		return $array;
// 	}

	
	
	/**
	 * 修改需求
	 * 生成单元之间的学习路径信息
	 * @param array $answer_time_arr 格式:$key=>array('unit_id', 'begin_time')
	 */
	function createUintLearnPathData($answer_time_arr) {
		
	    /*
	     * 方法的缺点：
	     * 效率低，foreach循环
	     */
	    
		$units = getUnitList();
		$student_id = self::$studentId;
		//$answer_time_arr 格式:$key=>array('unit_id', 'begin_time')
		
		$data = array();
		foreach ($answer_time_arr as $key=>$value){
			$query = "SELECT SUM(`learn_time`) `unit_learn_time`,`art_class_sort` FROM `curriculum_learn` cl 
						INNER JOIN `art_class` ac WHERE `student_id`={$student_id} AND `unit_id`={$value['unit_id']} 
						AND `begin_time`<='{$value['answer_time']}' AND cl.`unit_id`=ac.`art_class_id`";
			$result = mysql_query($query) or die(mysql_error());
			$row = mysql_fetch_assoc($result);
			$answer_time_arr[$key]['art_class_sort'] = (int)$row['art_class_sort'];
			if ($row['unit_learn_time'] == null) {
				$data[$value['unit_id']][] = 0;
			} else {
				$data[$value['unit_id']][] = round($row['unit_learn_time']/60);
			}
			unset($answer_time_arr[$key]['begin_time']);
		}
		
		//$answer_time_arr格式 $key=>array('unit_id','art_class_sort')
		
		$data_arr = array();
		$unit = array();
		$art_class_names = array();
		
		
		foreach ($answer_time_arr as $key => $value) {
		    $unit[] = $value['unit_id'];
		    $count_values = array_count_values($unit);
		    $current_count = $count_values[$value['unit_id']];
		    if ($current_count == 1) {
		        $answer_time_arr[$key]['learn_time'] = $data[$value['unit_id']][0];
		    } elseif ($current_count > 1) {
		        $answer_time_arr[$key]['learn_time'] = $data[$value['unit_id']][$current_count-1] - $data[$value['unit_id']][$current_count-2];
		    }
		}
		
		//$answer_time_arr格式 $key=>array('unit_id','art_class_sort','learn_time')
		
		/**
		 * 修改需求同一个单元连续学习归纳为一次，时间累加
		 * @author yan 2016-04-21
		 * */
		$unit = array();
		foreach ($answer_time_arr as $key=>$value) {
		    $art_class_sort = $value['art_class_sort'];
		    $pre = $key - 1;
		    if (($pre > 0) && ($value['unit_id'] == $answer_time_arr[$key-1]['unit_id'])) {
                $t = $value['learn_time'] + $answer_time_arr[$key-1]['learn_time'];
                $answer_time_arr[$key]['learn_time'] = $t;
                unset($answer_time_arr[$key-1]);
		    } 
		}
		
		$unit = array();
		foreach ($answer_time_arr as $key=>$value) {
		    $unit[] = $value['art_class_sort'];
		    $count_values = array_count_values($unit);
		    //首次学习
		    if ($count_values[$value['art_class_sort']] == 1) {
		        $a = array((int)$value['art_class_sort'], $value['learn_time']);
		        $art_class_names[$value['art_class_sort']] = $units[$value['unit_id']];
		        array_push($data_arr, $a);
		    }
		    //二次学习
		    else if ($count_values[$value['art_class_sort']] == 2) {
		        $a = array('marker'=>array('symbol'=>'square','lineColor'=>null, 'lineWidth'=>2),
		            'x'=>(int)$value['art_class_sort'], 'y'=>$value['learn_time']);
		        array_push($data_arr, $a);
		    }
		    //三次学习
		    else if ($count_values[$value['art_class_sort']] == 3) {
		        $a = array('marker'=>array('symbol'=>'triangle','lineColor'=>null, 'lineWidth'=>2),
		            'x'=>(int)$value['art_class_sort'], 'y'=>$value['learn_time']);
		        array_push($data_arr, $a);
		    }
		    //...之后的不管，不生成路径
		    else {
		        ;
		    }
		}
		$array = array('data'=>$data_arr,'art_class_names'=>$art_class_names);
		return $array;
	}
	
	
	/**
	 * 生成学习成绩数据
	 */
    public static function createLearnGradeData() {
    	//1.生成单元列表
    	if (($units = getUnitList()) == false) {return false;}
    	
    	//2.生成单元的学习时间
    	if (($unit_learn_time = getUnitLearnTime(self::$studentId)) == false) {return false;}
    	
    	//3.查询当前学生的学习成绩
    	$student_id = self::$studentId;
    	$units_id_str = implode(',', array_keys($units));
    	$query = "SELECT `correct_rate`,`unit_id` FROM `practice_record` pr INNER JOIN `practice` p WHERE `student_id`={$student_id}
    				AND pr.`pid`=p.`pid` ORDER BY CONCAT(`unit_id`,`answer_time`)";
    	$result = mysql_query($query) or die(mysql_error());
    	if (mysql_num_rows($result) <= 0) {return false;}	
    	$data = array();
    	while (($row = mysql_fetch_assoc($result)) != false) {
    		$data[$row['unit_id']][] = $row['correct_rate'];
    	}
    	$grade_data = array();
    	
    	//4.掌握知识次数统计
    	foreach ($units as $key=>$value) {
    	    if (!isset($data[$key])) {
    	        $grade_data['unit_learn_time'][] = 0;
    	    } else {
    	        $num = count($data[$key]);
    	        $i = 0;
    	        foreach ($data[$key] as $value)  {
    	            $i++;
    	            if ($value == 1) {
    	                $grade_data['unit_learn_time'][] = $i;
    	                break;
    	            }
    	            if ($i == $num) {
    	                $grade_data['unit_learn_time'][] = 0;
    	            }
    	        };
    	    }
    	}
    	//一次学习
    	foreach ($units as $key=>$value) {
    		if (isset($data[$key][0])) {
    			$grade_data['first'][] = intval($data[$key][0]*100);
    		} else {
    			$grade_data['first'][] = null;
    		}
    	}
    	//二次学习
    	foreach ($units as $key=>$value) {
    		if (isset($data[$key][1])) {
    			$grade_data['second'][] = intval($data[$key][1]*100);
    		} else {
    			$grade_data['second'][] = null;
    		}
    	}
    	//三次学习
    	foreach ($units as $key=>$value) {
    		if (isset($data[$key][2])) {
    			$grade_data['third'][] = intval($data[$key][2]*100);
    		} else {
    			$grade_data['third'][] = null;
    		}
    	}
    	$array = array('units'=>array_values($units),'grade_data'=>$grade_data);
    	return $array;
    }
}