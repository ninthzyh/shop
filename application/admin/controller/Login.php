<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 2018/7/18
 * Time: 13:38
 */

namespace app\admin\controller;

use think\captcha\Captcha;
use think\Controller;
use think\Db;

class Login extends Controller
{
    public function login()
    {
        return $this->fetch();
    }
    //验证码检测，把获取的验证码id在captcha库中进行验证，把输入的验证码保存在session中，提交的时候从session中取出进行比对
    public function login_submit($code='')
    {
//        var_dump($_POST);
        $check=Db::name('auth_user')
            ->where("name='".$_POST['account']."' && password='".md5($_POST['password'])."'")
            ->find();
//        var_dump($check);
//        exit;
        $captcha=new Captcha();
                if (($captcha->check($code)) && $check!=null)
            {
                session('user',$check);
               return $this->success("登录成功！",'admin/Index/index',3);
            }
            else
            {
               return $this->error("登录失败！");
            }
    }
}