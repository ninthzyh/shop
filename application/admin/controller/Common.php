<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 2018/7/20
 * Time: 14:33
 */

namespace app\admin\controller;


use think\Controller;
use \org\Auth;
use think\Request;

class Common extends Controller
{
    //任何函数加载时会调用此函数
    public function _initialize()
    {
        $uid=session('user')['id'];
//        dump($uid);exit;
        if (empty($uid))
        {
            return $this->error("请登录",'admin/login/login',3);
        }

         $AUTH=new \org\Auth;
        //认证规则时只认证控制器！！
//        var_dump( $AUTH->check( 'Index', 1 ) );
//        var_dump( $AUTH->check( 'Administrator', 1 ) );
//        var_dump( $AUTH->check( 'Product', 1 ) );
//        var_dump( $AUTH->check( 'admin/index/welcome', 2 ) );

        //获取module、controller、action地址
        $request=Request::instance();
        $module_name=$request->module();
        $controller_name=$request->controller();
        $action_name=$request->action();
        $name= $controller_name  ;
//        $name='Index';
        if(session('user')['role']==2)    //如果为2，是超级管理员不进行权限判断
           {
                return true;
           }
        else if (!$AUTH->check($name, session('user')['id']))
        {
//               exit;
            return $this->error("没有权限!",'admin/index/welcome',2);
        }


    }
}