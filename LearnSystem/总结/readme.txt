
ThinkPHP

1、关于自己的类库的加载问题
	注意命名空间的定义
	如果命名空间不在Library目录下面，并且没有定义对应的AUTOLOAD_NAMESPACE 参数的话，则会当作模块的命名空间进行自动加载
	new \Home\Model\UserModel(); ------>    Application/Home/Model/UserModel.class.php

2、自定义标签
	标签库请放置 ThinkPHP\Library\Think\Template\TagLib 目录下，若需要存放在指定位置，请在加载标签库配置时使用命名空间，如
	<taglib name="Home\\TagLib\\MyTag"/>