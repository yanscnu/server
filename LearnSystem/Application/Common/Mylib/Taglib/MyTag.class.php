<?php
namespace Common\Mylib\Taglib;
use Think\Template\TagLib;
defined('THINK_PATH') or exit();

class MyTag extends TagLib
{
    // 标签定义
    protected $tags   =  array(
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'module_js'    => array('attr'=>'src,type,charset','close'=>0),
        'module_css'    => array('attr'=>'href,rel,type','close'=>0),
        'bootstrap'     => array('attr'=>'version','close'=>0),
        'jquery'     => array('attr'=>'version','close'=>0),
    );
    
    /**
     * 模块js标签    引入当前模块的js文件(文件要求存放在:  ./Public/模块目录/js/)
     * 格式： <mytag:module_js src='' type='' charset='' />
     * @access public
     * @param array $tag 标签属性
     * @return string|void
    */
    public function _module_js($tag) {
        if (empty($tag['src'])) {
            return '';
        }
        $src = __ROOT__ . '/Public/' . MODULE_NAME . '/js/' . $tag['src'];
        $type = empty($tag['type']) ? 'text/javascript' : $tag['type'] ;
        $charset = empty($tag['charset']) ? 'UTF-8' : $tag['charset'] ;
        
        $parseStr = "<script src=\"{$src}\" type=\"{$type}\" charset=\"{$charset}\"></script>";
    
        return $parseStr;
    }
    
    /**
     * 模块css标签    引入当前模块的css文件(文件要求存放在:  ./Public/模块目录/css/)
     * 格式： <mytag:module_css rel='' type='' href='' />
     * @access public
     * @param array $tag 标签属性
     * @return string|void
     */
    public function _module_css($tag) {
        if (empty($tag['href'])) {
            return '';
        }
        $href = __ROOT__ . '/Public/' . MODULE_NAME . '/css/' . $tag['href'];
        $type = empty($tag['type']) ? 'text/css' : $tag['type'] ;
        $rel = empty($tag['rel']) ? 'stylesheet' : $tag['rel'] ;
    
        $parseStr = "<link rel=\"{$rel}\" type=\"{$type}\" href=\"{$href}\" />";
    
        return $parseStr;
    }
 
    /**
     * bootstrap插件引入标签    (文件要求存放在:  ./Public/Component/)
     * 格式： <mytag:bootstrap version='3.1.1' />
     * @access public
     * @param array $tag 标签属性
     * @return string|void
     */
    public function _bootstrap($tag) {
        $version = empty($tag['version']) ? '3.1.1' : $tag['version'];
        $path = __ROOT__ . '/Public/Component/bootstrap/';
        $parseStr = <<<STR
<!-- Bootstrap 核心 CSS 文件 -->
<link rel="stylesheet" href="{$path}{$version}/bootstrap.min.css" type="text/css">
<!-- Bootstrap 核心 JavaScript 文件 -->
<script src="{$path}{$version}/bootstrap.min.js" type="text/javascript" charset="UTF-8"></script>
STR;
        return $parseStr;
    }
    
    /**
     * jquery插件引入标签    (文件要求存放在:  ./Public/Component/)
     * 格式： <mytag:bootstrap version='3.1.1' />
     * @access public
     * @param array $tag 标签属性
     * @return string|void
     */
    public function _jquery($tag) {
        $version = empty($tag['version']) ? '1.5.2' : $tag['version'];
        $path = __ROOT__ . '/Public/Component/jquery/';
        $parseStr = <<<STR
<!-- jquery js文件 -->
<script src="{$path}jquery-{$version}.min.js" type="text/javascript" charset="UTF-8"></script>
STR;
        return $parseStr;
    }
    
}

?>