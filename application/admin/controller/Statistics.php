<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 2018/6/21
 * Time: 12:12
 */

namespace app\admin\controller;
use think\Controller;
use think\Db;

class Statistics extends  Controller
{
    public function charts_1()
    {
        return $this->fetch();
    }
    public function charts_1_ajax()
    {
        $data=Db::name('charts_1')->field('id,names,datas')->select();

        echo json_encode($data);

    }
    public function charts_heading_ajax()
    {
        $title=Db::name('heading')->field('id,xAxis,ytitle,head,source')->select();

        echo json_encode($title);

    }
    public function charts_2()
    {
        return $this->fetch();
    }
    public function charts_3()
    {
        return $this->fetch();
    }
    public function charts_4()
    {
        return $this->fetch();
    }
    public function charts_5()
    {
        return $this->fetch();
    }
    public function charts_6()
    {
        return $this->fetch();
    }
    public function charts_7()
    {
        return $this->fetch();
    }
}