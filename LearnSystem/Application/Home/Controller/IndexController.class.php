<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {
    
    public function index(){
        $stuModel = D('Student');
       $data = $stuModel->getStudents();
       var_dump($data);
	   $this->display();
    }
    
    public function login() {
        $this->display();
    }
}