<?php
	return array(
		/*--------站点相关信息配置--------*/
		'WEBSITE_NAME'=>'DOERS学习平台',
		'PROJECT_NAME' => 'weixin',
		
		/*--------数据库相关信息配置--------*/
		'DB_HOST' => 'localhost:3306',
		'DB_USER' => 'root',
		'DB_PASS' => 'yanscnu197',
		'DB_NAME' => 'doers',
	    'SHOW_SQL_ERROR'=>true,       //是否显示sql错误
		
		/*--------相关信息配置--------*/
		'MIN_READ_TIME'=>5,	//最小阅读时间，当阅读时间大于该值的时候才记录到数据库
		'ONLINE_TIME'=>30,	//在线时间的差距大于该值时进行更新
	);
?>
