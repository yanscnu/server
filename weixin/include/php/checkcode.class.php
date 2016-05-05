<?php
class checkcode{
    //资源
    private $img;
    //画布宽度
    public $width = 100;
    //画布高度
    public $height = 30;
    //背景颜色
    public $bg_color = '#DCDCDC';
    //验证码
    public $code;
    //验证码生成的随机种子
    public $code_str = 'QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm1234567890';
    //验证码长度
    public $code_len = 4;
    //验证码字体
    public $font;
    //验证码字体大小
    public $font_size = 20;
    //验证码字体颜色
    public $font_color = '#000000';
    
    /*
     * 构造函数
     */
    public function __construct(){
        $this->create_code();
        $this->create_img();
        $this->create_font();
    }
    /*
     * 生成验证码
     */
    private function create_code(){
        $code = "";
        for ($i=0;$i<$this->code_len;$i++){
            $code .= $this->code_str[mt_rand(0, strlen($this->code_str)-1)];
        }
        $this->code = $code;
        if (!session_id()) {
        	session_start();
        }
        $_SESSION['checkcode'] = strtoupper($this->code);
    }
    /*
     * 返回验证码
     */
    public function getcode(){
        return $this->code;
    }
    
    public function show_code(){
		 header("Content-type: image/png");
		 imagepng($this->img);
    }
    
    /*
     * 创建画布和背景
     */
    private function create_img(){
        $img = imagecreatetruecolor($this->width, $this->height);
        $bg_color = $this->bg_color;
        $bg_color = imagecolorallocate($img, hexdec(substr($bg_color,1,2)), hexdec(substr($bg_color,3,2)), hexdec(substr($bg_color,5,2)));
        imagefill($img, 0, 0, $bg_color);
        $this->img = $img;
    }
    
    private function create_font(){
        $color = $this->font_color;
        $font_color = imagecolorallocate($this->img, hexdec(substr($color,1,2)), hexdec(substr($color,3,2)), hexdec(substr($color,5,2)));
        for ($i = 0; $i < $this->code_len; $i++) {
            $x = 3+($this->width/$this->code_len)*$i; //水平位置
            $y = rand(0, imagefontheight($this->font_size)-3);
            imagechar($this->img, $this->font_size, $x, $y, $this->code[$i], $font_color);
        }
    }
    
    /*
     * 析构函数
     */
    function __destruct(){
        imagedestroy($this->img);
    }
}