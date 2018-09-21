<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 2018/6/21
 * Time: 12:12
 */

namespace app\admin\controller;
use think\Controller;

class Picture extends Controller
{
    public function pictureList()
    {
        return $this->fetch();
    }
    public function pictureAdd()
    {
        return $this->fetch();
    }
}