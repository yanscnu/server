<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

/* //定义网站主机
$protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'HTTP') == false ? 'http' : 'https';
defined('__HOST__') or define('__HOST__', $protocol . '://' . $_SERVER['HTTP_HOST']);

//定义本站点的URL
$root = basename(dirname($_SERVER['SCRIPT_FILENAME']));
defined('__WEBSITE__') or define('WEBSITE_URL', __HOST__ . '/' . $root);

//定义站点资源文件的URL
defined('__PUBLIC__') or define('__PUBLIC__', WEBSITE_URL . '/Public');

//定义站点资源文件的插件目录的URL
defined('__COMPONENT__') or define('__COMPONENT__', __PUBLIC__ . '/Component'); */


// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',true);

// 定义应用目录
define('APP_PATH','./Application/');


//定义框架目录
define('THINK_PATH',realpath('../ThinkPHP').'/');


// 引入ThinkPHP入口文件
require THINK_PATH . 'ThinkPHP.php';

// $const_user = get_defined_constants(true);
// var_dump($const_user['user']);

// 亲^_^ 后面不需要任何代码了 就是如此简单