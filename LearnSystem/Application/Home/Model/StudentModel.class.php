<?php
namespace Home\Model;

use Think\Model;

class StudentModel extends Model
{
    protected $tableName = 'student';
    
    public function getStudents(){
        return $this->limit(0,10)->select();
    }
    
}