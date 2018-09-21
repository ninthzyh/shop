<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 2018/6/21
 * Time: 12:11
 */

namespace app\admin\controller;
use think\Controller;

class System extends Controller
{
    public function systemBase()
    {
        return $this->fetch();
    }
    public function systemCategory()
    {
        return $this->fetch();
    }
    public function systemData()
    {
        return $this->fetch();
    }
    public function systemShielding()
    {
        return $this->fetch();
    }
    public function systemLog()
    {
        return $this->fetch();
    }
}