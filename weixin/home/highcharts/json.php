<?php
	require_once('../Control/MemberControl.php');
	if(isLogin() == false){
		toLoginPage();
	}
	$student_id = $_SESSION['student_id'];
	$query = "SELECT `learn_time`,`art_class_sort` from `curriculum_learn` INNER JOIN `art_class` where 
				`student_id`={$student_id} AND `curriculum_learn`.`curriculum_id`=`art_class`.`art_class_id` 
				ORDER BY `begin_time` ASC";
	$result = mysql_query($query) or die(mysql_error());
	$arr = array();
	$key_count = array();
	while ($row = mysql_fetch_assoc($result)) {
		$time = round($row['learn_time']/60);
		if (!key_exists($row['art_class_sort'], $key_count)) {
			$key_count[$row['art_class_sort']] = 1;
		}
		if (key_exists($row['art_class_sort'], $arr)) {
			$key_count[$row['art_class_sort']] ++;
			if ($key_count[$row['art_class_sort']] == 2) {
				$arr[] = array('marker'=>array('symbol'=>'square','lineColor'=>null, 'lineWidth'=>2), 
						'x'=>$row['art_class_sort'], 'y'=>$time);
			}
		} else {
			$arr[$row['art_class_sort']] = $time;
		}
	}
	$array1 = array();
	foreach ($arr as $key => $value) {
		if (is_array($value)) {
			array_push($array1, $value);
		}else {
			$a = array($key, $value);
			array_push($array1, $a);
		}
	}
	
	$array2 = array('data'=>$array1);
	
	exit(json_encode($array2));
	
	
	/**
	 * 不连接数据库的情况
	 */
	// 	$array1 = array(
	// 			array(1, 10), array(2, 15), array(3, 10),
	// 			array(4, 25), array(5, 18));
	
	// 	$object2 = array('marker'=>array('symbol'=>'square','lineColor'=>null, 'lineWidth'=>2), 'x'=>3, 'y'=>20);
	
	// 	array_push($array1, $object2);
	
	// 	array_push($array1, array(6,30));
	// 	array_push($array1, array(7,20));
	// 	array_push($array1, array(8,25));
	