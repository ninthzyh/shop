<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 2018/6/21
 * Time: 12:12
 */

namespace app\admin\controller;
use app\admin\model\AuthGroup;
use app\admin\model\AuthGroupAccess;
use app\admin\model\AuthRule;
use app\admin\model\AuthUser;
use think\Controller;
use \org\auth;
use think\Db;
use think\Request;

class Administrator extends Common
{
    //角色管理把信息显示在页面中
        public function adminRole()
        {
            $auth_role_show=Db::name('auth_group')->where('status',1)->select();
//            var_dump($auth_role_show);
            $this->assign('auth_role_show',$auth_role_show);
            $count=Db::name('auth_group')->count();
            $this->assign('count',$count);
            return $this->fetch();
        }
        //删除单个角色
        public function admin_role_del()
        {
            $request=Request::instance();
            $id=$request->param();
            $auth_role_del=Db::name('auth_group')->delete($id);
            if ($auth_role_del)
            {
                return $this->success("删除成功！");
            }
            else
            {
                return $this->error("删除失败！");
            }
        }
        //角色管理添加角色保存在数据库中
        public function auth_role_add()
        {
    //            var_dump($_POST);
            $auth_role_list['title']=$_POST['rolename'];
            $auth_role_list['group']=$_POST['group_id'];
            $auth_role_list['status']=1;
            $auth_role_list['rules']= $_POST['group_id'];
//            dump($auth_role_list);exit;
            $auth_title=Db::name('auth_group')->where("title='".$auth_role_list['title']."'")->find();
//            dump($auth_title);exit;
            if (!$auth_title)
            {
                $auth_role_list=new AuthGroup($auth_role_list);
                $auth_role_list->save();
                if ($auth_role_list)
                {
                    return $this->success("角色信息添加成功！",'administrator/adminRole',3);
                }
                else
                {
                    return $this->error("角色信息添加失败！",'administrator/adminRoleAdd',3);
                }
            }
            else
            {
                return $this->error("用户名已存在！",'administrator/adminRoleAdd',3);
            }

        }
        //角色管理编辑现有的角色获取
        public function adminRoleEdit()
        {
            $request=Request::instance();
            $id=$request->param();
            $auth_role_edit=Db::name('auth_group')->find($id);
            //            var_dump($auth_role_edit);
            $this->assign('auth_role_edit',$auth_role_edit);
            return $this->fetch();
        }
        //角色管理编辑现有的角色修改
        public function auth_role_edit_new()
        {
//            var_dump($_POST);exit;
            $auth_role_list['title']=$_POST['rolename'];
            $auth_role_list['group']=$_POST['group_id'];
            $auth_role_list['status']=1;
            $auth_role_list['id']=$_POST['id'];
            $auth_role_list['rules']=$_POST['group_id'];
//            var_dump($auth_role_list);exit;
            $res=new AuthGroup;
            $res->isUpdate(true)->save($auth_role_list);

//            dump($res); exit;

            if ($res)
            {
                return $this->success("角色信息添加成功！",'administrator/adminRole',3);
            }
            else
            {
                return $this->error("角色信息添加失败！",'administrator/adminRoleAdd',3);
            }

        }
        //权限管理
        public function adminPermission()
        {
            $admin_permission_show=Db::name('auth_rule')->select();
//            var_dump($admin_permission_show);
            $this->assign('admin_permission_show',$admin_permission_show);
            $count=Db::name('auth_rule')->count();
            $this->assign('count',$count);
            return $this->fetch();
        }
        //权限管理添加
        public function adminPermissionAdd()
        {

            return $this->fetch();
        }
        //角色管理添加角色
        public function adminRoleAdd()
        {
            return $this->fetch();
        }
        //权限管理添加节点保存在数据库
        public function auth_rule_add()
        {
//            var_dump($_POST);
            $admin_rule_list['title']=$_POST['title'];
            $admin_rule_list['name']=$_POST['name'];
            $admin_rule_list=new AuthRule($admin_rule_list);
            $admin_rule_list->save();
            if($admin_rule_list)
            {
                return $this->success("添加成功",'administrator/adminPermissionAdd',3);
            }
            else
            {
                return $this->error("添加失败",'administrator/adminPermissionAdd',3);
            }
        }
        //权限管理编辑页面
        public function adminPermissionEdit()
        {
            $request=Request::instance();
            $id=$request->param();
            $admin_preminssion_edit=Db::name('auth_rule')->find($id);
            $this->assign('admin_permission_edit',$admin_preminssion_edit);
            return $this->fetch();
        }
        //权限管理编辑在数据库中更改
        public  function auth_permission_edit()
        {
//            var_dump($_POST);
            $admin_rule_list['title']=$_POST['title'];
            $admin_rule_list['name']=$_POST['name'];
            $admin_rule_list['id']=$_POST['id'];
            $res=new AuthRule;
            $res->isUpdate(true)->save($admin_rule_list);
            if ($res)
            {
                return $this->success("修改成功",'administrator/adminPermission');
            }
            else
            {
                return $this->error("修改失败",'administrator/adminPermissionEdit');
            }
        }
        //权限管理删除
        public function auth_permission_del()
        {
            $request=Request::instance();
            $id=$request->param();
            $admin_permission_del=Db::name('auth_rule')->delete($id);
            if($admin_permission_del)
            {
                return $this->success("删除成功");
            }
            else
            {
                return $this->error("删除失败");
            }
        }
        //管理员列表
        public function adminList()
        {
            $admin_list_show=Db::name('auth_user')->select();
//            dump($admin_list_show);
            $this->assign('admin_list_show',$admin_list_show);
            $count=Db::name('auth_user')->count();
            $this->assign('count',$count);
            return $this->fetch();
        }
        //角色管理列表添加页面
        public function adminAdd()
        {
            return $this->fetch();
        }
        //管理员列表，添加管理员个人信息保存在数据库
        public function auth_add()
        {
//            var_dump($_POST);
            $auth_add_list['name']=$_POST['name'];
            //要用MD5加密首先在获取password的时候要用如下方式，再在登录Login.php的时候获取MD5的加密密码，就会以MD5的形式保存在数据库
            $auth_add_list['password']=md5($_POST['password']);
            $auth_add_list['sex']=$_POST['sex'];
            $auth_add_list['tel']=$_POST['tel'];
            $auth_add_list['email']=$_POST['email'];
            $auth_add_list['role']=$_POST['role'];

            $name=Db::name('auth_user')->where("name='".$auth_add_list['name']."'")->find();
//            dump($name);exit;
            if (!$name) //如果name不存在
            {
                $auth_add_list=new AuthUser($auth_add_list);
                $auth_group=new AuthGroupAccess();
//            var_dump($auth_add_list);
//            if ()
                $auth_add_list->save();

                $auth_group['group_id']=$_POST['role'];
                $auth_group['uid']=$auth_add_list['id'];
//                dump($auth_group);exit;
                $auth_group->save();
                if ($auth_add_list && $auth_group)
                {
                    return $this->success("添加成功",'administrator/adminAdd',3);
                }
                else
                {
                    return $this->error("添加失败",'administrator/adminAdd',3);
                }
            }
            else       //如果name存在则是用户名重复
            {
                return $this->error("当前用户名已存在！",'administrator/adminAdd',3);
            }


        }
        //管理员列表编辑页面
        public function adminEdit()
        {
            $request=Request::instance();
            $id=$request->param();
            $admin_edit=Db::name('auth_user')->find($id);
//            var_dump($admin_edit);
            $this->assign('admin_edit',$admin_edit);
            return $this->fetch();
        }
        //管理员列表编辑在数据库中更新数据
        public function auth_edit()
        {
//            var_dump($_POST);exit;
            $auth_add_list['name']=$_POST['name'];
            $auth_add_list['password']=md5($_POST['password']);
            $auth_add_list['sex']=$_POST['sex'];
            $auth_add_list['tel']=$_POST['tel'];
            $auth_add_list['email']=$_POST['email'];
            $auth_add_list['role']=$_POST['role'];
            $auth_add_list['id']=$_POST['id'];
            $res=new AuthUser;
            $res->isUpdate(true)->save($auth_add_list);
            if ($res)
            {
                return $this->success("修改成功",'administrator/adminList');
            }
            else
            {
                return $this->error("修改失败",'administrator/adminEdit');
            }
        }
        //管理员列表删除
        public function auth_del()
        {
            $request=Request::instance();
            $id=$request->param();
            $admin_del=Db::name('auth_user')->delete($id);
            if($admin_del)
            {
                return $this->success("删除成功");
            }
            else
            {
                return $this->error("删除失败");
            }
        }


}