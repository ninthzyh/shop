<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 2018/6/18
 * Time: 21:09
 */

namespace app\index\model;

use think\Model;

class Lesson extends Model
{
    protected function getNameAttr1($name,$data)
    {
        //return 'old'.$jointime;
        //return date('Y-m-d h:i:s'.$jointime);
        return 'your name:'. $name.'your id:'.$data['id'];
        return"your name:$name your id: {$data['id']}";
    }
    protected function setJointimeAttr1($value)
    {
        return strtotime($value);
    }
//    protected $type =array(
//        'name'=>'json'
//    );
    protected $update=array(
        'sex'=>1
    );
    protected function setSexAttr($sex,$data)
    {
        return $data['pic']=='man.jpg'? 1:0;
    }
    protected function scopeEmail($query)
    {
        $query->where('email','asd@123.com');
    }
    protected function scopeName($query,$a)
    {
        //$query->where('name','smy');
        $query->where('name',$a);
    }
}