<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 2018/6/20
 * Time: 12:17
 */
namespace app\app_extend\controller\seckill;
use think\Controller;
class Index extends Controller
{
    public function index ()
    {
        return $this->fetch(index.html);
    }
}