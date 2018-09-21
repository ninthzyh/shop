<?php
namespace app\admin\controller;
use app\index\model\Goods;
use app\index\model\GoodsList;
use think\Controller;
use think\Request;

class Index extends Common
{
    public function index()
    {
//        return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ad_bd568ce7058a1091"></think>';
       //显示用户名
        $uid=session('user')['name'];
//        dump($uid);
        $role=session('user')['role'];
//        dump($group_id);exit;

        $this->assign('uid',$uid);
        $this->assign('role',$role);

//        exit;
        return $this->fetch();
    }
    public function welcome()
    {
        $ip=Request::instance()->ip();
        $this->assign('ip',$ip);
        return $this->fetch();
    }
    //退出登录销毁session
    public function loginout()
    {
        session(null);
        return $this->success("退出成功",'admin/login/login');
    }
}
