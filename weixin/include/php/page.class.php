<!--
	作者：1091780277@qq.com
	时间：2015-11-04
	描述：分页类
-->

<?php
	//header("Content-type: text/html; charset=utf-8");

	class Page{
		private $total;		//总记录数
		private $nums;		//规定每页显示的记录数
		private $pages;		//总页数  ，根据总记录数和规定的每页显示的记录数来计算
		private $cpage;		//当前的页数
		private $uri;		//请求的URI
		private $limit;		//limit语句的限制
		
		/*
		 *	构造函数
		 * 	@param $total: 总记录数
		 * 	@param $nums: 规定每页显示的记录数，默认是15
		 * 	@param $query: 传入URI的附件参数，默认是空
		 */
		public function __construct($total,$nums=15,$query=""){
			$this->total = $total;
			$this->nums = $nums;
			$this->pages = $this->getPages();
			//获取当前页
			$this->cpage = !empty($_GET['page']) ? $_GET['page']:1;
			//避免删除某页的最后一条记录后，页数减少1带来的错误
			if($this->cpage > $this->pages){
				$this->cpage = $this->pages;
			}
			//设置URI
			$this->uri = $this->setUri($query);
			//设置分页的limit限制（用于数据库查询）
			$this->limit = "limit ".$this->setLimit();
		}
		
		/*
		 * 构造URI
		 * @param $query: 传入的附件URI参数
		 */
		private function setUri($query) {
			$request_uri = $_SERVER["REQUEST_URI"];	//从SERVER变量获取请求URI
			//判断URI中是否有请求参数
			$url = strstr($request_uri,'?') ? $request_uri :  $request_uri.'?';
			
			if(is_array($query)){
				$url .= http_build_query($query);
			}else if($query != ""){
				$url .= "&".trim($query, "?&");	//去除‘?&’,再添加到返回的URL
			}
			
			$arr = parse_url($url);	// 解析 URL，返回其组成部分
			if(isset($arr["query"])){
				parse_str($arr["query"], $arrs);	//将字符串解析成多个变量
				unset($arrs["page"]);		//去除参数page
				$url = $arr["path"].'?'.http_build_query($arrs);
			}
			
			if(strstr($url, '?')) {
				if(substr($url, -1)!='?')	//判断URL最后一个字符是否是'?'
					$url = $url.'&';
			}else{
				$url = $url.'?';
			}
			return $url;
		}
		
		/*
		 * 生成limit子句
		 */
		private function setLimit(){
			if($this->cpage > 0)
				//起始记录位置,读取的记录数
				return ($this->cpage-1)*$this->nums.", {$this->nums}";
			else
				return 0;
		}
		
		/*
		 * 访问内部成员变量的方法
		 */
		function __get($args){
			if($args == "limit" || $args == "cpage")
				return $this->$args;
			else
				return null;
		}
		
		/*
		 * 计算总页数
		 */
		private function getPages(){
			return ceil($this->total/$this->nums);
		}
		
		/*
		 * 首页、上一页相关
		 */
		function first(){
			if($this->cpage > 1){
				$prev = $this->cpage - 1;
				return '<a href="'.$this->uri.'page=1">首页</a>  <a href="'.$this->uri.'page='.$prev.'">上一页</a>';
			}else{
				return "";
			}
			
		}
		
		/*
		 * 页码列表
		 */
		function flist(){
			$list = "";
			$num = 4;	//设置当前页之前和之后显示多少页
			//当前页之前
			for ($i=$num; $i>=1 ; $i--) { 
				$page = $this->cpage - $i;
				if($page > 0){
					$list .= '<a href="'.$this->uri.'page='.$page.'">' . $page . '</a>&nbsp;&nbsp;';
				}
			}
			
			//当前页
			if($this->pages > 1){
				$list .= "<font style='font-size:20px;color:red;'>{$this->cpage}</font>&nbsp;&nbsp;";	
			}
			
			//当前页之后
			for ($i=1; $i <= $num; $i++) { 
				$page = $this->cpage + $i;
				if($page > $this->pages){
					break;
				}
				$list .= '<a href="'.$this->uri.'page='.$page.'">' . $page . '</a>&nbsp;&nbsp;';
			}
			return $list;
		}
		
		/*
		 * 下一页、末页相关
		 */
		function last(){
			if($this->cpage < $this->pages){
				$next = $this->cpage + 1;
				return '<a href="'.$this->uri.'page='.$next.'">下一页</a>&nbsp;&nbsp;<a href="'.$this->uri.'page='.$this->pages.'">末页</a>';
			}else{
				return "";
			}
		}
		
		/*
		 * 当前页的起始记录
		 */
		private function start(){
			return ($this->cpage - 1)*$this->nums+1;
		}
		
		/*
		 * 当前页的结束记录
		 */
		private function end(){
			//需要判断是否超过总页数
			return min($this->cpage*$this->nums , $this->total);
		}
		
		//当前页显示的记录条数
		private function currnum(){
			return $this->end()-$this->start()+1;
		}
		
		/*
		 * 外部接口：输出分页的列表
		 * 调用的时候可传入参数6个参数0-6,传入某项数值代表启用对应的功能，不传参数默认全部开启
		 */
		function fpage(){
			$fpage = "";
			$pages[0] = "&nbsp;共{$this->total}条记录&nbsp;&nbsp;";
			$pages[1] = "本页显示".$this->currnum()."条记录&nbsp;";
			$pages[2] = "从".$this->start()."-".$this->end()."条&nbsp;";
			$pages[3] = "{$this->cpage}/{$this->pages}&nbsp;&nbsp;";
			$pages[4] = $this->first()."&nbsp;&nbsp;";
			$pages[5] = $this->flist()."&nbsp;&nbsp;";
			$pages[6] = $this->last()."&nbsp;&nbsp;";
			
			$arr = func_get_args();
			if(count($arr) < 1){
				$arr = array(0,1,2,3,4,5,6);
			}
			
			foreach ($arr as $n) {
				$fpage .= $pages[$n]; 
			}
			return $fpage;
		}
	}
?>
