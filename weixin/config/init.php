<?php
	$config = require_once('config.php');
	
	foreach($config as $key=>$value){
		defined($key) or define($key, $value);
	}
	//站点跟路径
	defined('DOCUEMNT_ROOT') or define('DOCUEMNT_ROOT', rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']),'/'));
	
	//项目跟路径（服务器端绝对路径，用于服务器访问本机文件，如删除，修改文件，格式：E:/www/weixin/）
	defined('ROOT_PATH') or define('ROOT_PATH', DOCUEMNT_ROOT.'/'.PROJECT_NAME.'/');
	//网络路径，前台访问所有路径,格式http://(域名)/weixin/
	defined('__ROOT__') or define('__ROOT__', 'http://'.$_SERVER['SERVER_NAME'].'/'.PROJECT_NAME.'/');
	
	//缩略图服务器端路径
	defined('THUMBNAIL_PATH') or define('THUMBNAIL_PATH', ROOT_PATH.'upload/thumbnail/');
	//缩略图网络路径
	defined('__THUMBNAIL__') or define('__THUMBNAIL__', __ROOT__.'upload/thumbnail/');
	
	//包含的插件的服务器端路径
	defined('INCLUDE_PATH') or define('INCLUDE_PATH', ROOT_PATH.'include/');
	//包含的插件的网络路径
	defined('__INCLUDE__') or define('__INCLUDE__', __ROOT__.'include/');
	
	/**
	 * 连接数据库
	 */
	if(!isset($con)){
		$con=mysql_connect(DB_HOST,DB_USER,DB_PASS);
		if (!$con){
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db(DB_NAME, $con);
		mysql_query("set names utf8");
	}
	
	//引入核心函数库
	require_once ROOT_PATH.'lib/functions.php';
	header('Content-Type:text/html;charset=utf-8');
?>