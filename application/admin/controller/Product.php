<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 2018/6/21
 * Time: 12:13
 */

namespace app\admin\controller;
use app\admin\model\Goods;
use app\admin\model\GoodsList;
use think\Controller;
use think\Db;
use think\Request;

class Product extends Common
{
    public function productCategory()
    {
        return $this->fetch();
    }
    public function productCategoryAdd()
    {
//        $goods_list = Goods::all();
        $goods_list=Db::table('goods')->field("*,concat(path,',',id) as paths")->order('paths')->select();
//        print_r($goods_list);
        foreach ($goods_list as $k=>$vo)
        {
            $goods_list[$k]['name']=str_repeat("|---",$vo['level']).$vo['name'];
        }
//        print_r($goods_list);
        $this->assign('goods_list',$goods_list);
        return $this->fetch();
    }
    //添加分类信息到数据库
    public function goods_type_add()
    {
//        var_dump($_POST);
        $goods_list['name']=$_POST['name'];
        $goods_list['pid']=$_POST['pid'];
        if($goods_list['name']!="" && $goods_list['pid']!=0)
        {
            $goods_list =new Goods($_POST);
            $path=Db::table('goods')->field("path")->find($goods_list['pid']);
            $goods_list['path']=$path['path'];
            $goods_list->save();
            $goods_list->id;
            $goods_list['path']=$goods_list['path'].','.$goods_list['id'];
            $goods_list->save();
            $goods_list['level']=substr_count($goods_list['path'],",");
            $res=$goods_list->save();
//            var_dump($goods_list);
                if($res){
                    $this->success('添加成功','Product/productCategoryAdd');
                }else{
                   $this->error('添加失败','Product/productCategoryAdd');
                }

        }elseif ($goods_list['name']!="" && $goods_list['pid']==0)
        {
            $goods_list =new Goods($_POST);
//            $path=Db::table('goods')->field("path")->find($goods_list['pid']);
//            $goods_list['path']=$path['path'];
            $goods_list->save();
            $goods_list->id;
            $goods_list['path']='0,'.$goods_list['id'];
            $goods_list->save();
            $goods_list['level']=substr_count($goods_list['path'],",");
            $res=$goods_list->save();
//            var_dump($goods_list);
            if($res){
                $this->success('添加成功','Product/productCategoryAdd');
            }else{
                $this->error('添加失败','Product/productCategoryAdd');
            }
        }
        else
        {
            $this->error('添加失败，备注不能为空','Product/productCategoryAdd');
        }
    }
    //获取分类数据
    public function product_category_ajax()
    {
//        $classification=new Goods();
        $classification=Db::table('goods')->field('id,pid,name')->select();
        echo json_encode($classification);
    }
    //删除分类
    public function product_category_del()
    {
//        var_dump($_GET);
        $delid=$_GET['id'];
//        console.log($id);
//        $data=new Goods($_GET);
        $del=Db::table('goods')  ->where('pid','=',$delid)->select();

//        var_dump($data);
        if ($del)
        {
            $str="分类下有子分类，不允许删除";
            echo json_encode($str);
        }
        else
        {
//            $data->delete();
            db('goods')->delete($delid);
            $str="1";
            echo json_encode($str);
            if($del)
            {
                echo 1;
            }
        }
    }
    public function productAdd()
    {
//        $goods_list=Goods::all();
        $goods_list=Db::table('goods')->field("*,concat(path,',',id) as paths")->order('paths')->select();
        foreach ($goods_list as $k=>$vo)
        {
            $goods_list[$k]['name']=str_repeat('|---',$vo['level']).$vo['name'];
        }
        $this->assign('goods_list',$goods_list);
        return $this->fetch();
    }
    //添加商品页
    public function product_add_goods()
    {
//        var_dump($_POST);
//        ;exit;

        $goods_list_add['goodsname']=$_POST['goodsname'];
        $tid=explode(',',$_POST['tid']);
        $goods_list_add['tid']=$tid[0];
        $goods_list_add['tpid']=$tid[1];
        $goods_list_add['unit']=$_POST['unit'];
        $goods_list_add['attributes']=$_POST['attributes'];
        $goods_list_add['number']=$_POST['number'];
        $goods_list_add['barcode']=$_POST['barcode'];
        $goods_list_add['curprice']=$_POST['curprice'];
        $goods_list_add['oriprice']=$_POST['oriprice'];
        $goods_list_add['cosprice']=$_POST['cosprice'];
        $goods_list_add['inventory']=$_POST['inventory'];
        $goods_list_add['restrict']=$_POST['restrict'];
        $goods_list_add['already']=$_POST['already'];
        $goods_list_add['freight']=$_POST['freight'];
        $goods_list_add['status']=$_POST['status'];
        $goods_list_add['reorder']=$_POST['reorder'];
//解决tp未定义数组索引: editorValue，用isset去判断
        if (isset($goods_list_add['text'])) {
            echo $goods_list_add['text'];
        } else {
            echo '';
        }
        $goods_list_add['text']=$_POST['editorValue'];
        $goods_list_add['imagepath']='';

        $goods_list_add=new GoodsList($goods_list_add);
//        var_dump($goods_list_add);
//        exit;

        $goods_list_add->save();
        if ($goods_list_add)
        {
           return $this->success("添加产品信息成功！",'Product/productList',5);
        }
        else
        {
           return $this->error("添加产品信息失败",'Product/productList',5);
        }
    }
    public function productBrand()
    {
        return $this->fetch();
    }
    public function productList()
    {

        $goods_list_show=GoodsList::all();

        $this->assign('goods_list_show',$goods_list_show);
        $count= Db::name('goods_list')->count();//获取数据数量
        $this->assign('count',$count);
        return $this->fetch();
    }
    public function productEdit()
    {
        //请求url参数
        $request = Request::instance();
//        echo 'url with domain: ' . $request->url(true) . '<br/>';  //请求完整url地址
        $id=$request->param();//请求url id
//        dump($goods_edit);exit;
        //把请求的id传入
        $goods_edit=Db::table('goods_list')->find($id);
//        var_dump($goods_edit);
        $this->assign('goods_edit',$goods_edit);
//        exit;
        //编辑中获取分类栏目
        $goods_list=Db::table('goods')->field("*,concat(path,',',id) as paths")->order('paths')->select();
        foreach ($goods_list as $k=>$vo)
        {
            $goods_list[$k]['name']=str_repeat('|---',$vo['level']).$vo['name'];
        }
        $this->assign('goods_list',$goods_list);
        return $this->fetch();

    }
//修改商品属性数据库表goods_list
    public function product_edit_new()
    {
//        var_dump($_POST);exit;
        $goods_list_add['goodsname']=$_POST['goodsname'];
        $tid=explode(',',$_POST['tid']);
        $goods_list_add['tid']=$tid[0];
        $goods_list_add['tpid']=$tid[1];
        $goods_list_add['unit']=$_POST['unit'];
        $goods_list_add['attributes']=$_POST['attributes'];
        $goods_list_add['number']=$_POST['number'];
        $goods_list_add['barcode']=$_POST['barcode'];
        $goods_list_add['curprice']=$_POST['curprice'];
        $goods_list_add['oriprice']=$_POST['oriprice'];
        $goods_list_add['cosprice']=$_POST['cosprice'];
        $goods_list_add['inventory']=$_POST['inventory'];
        $goods_list_add['restrict']=$_POST['restrict'];
        $goods_list_add['already']=$_POST['already'];
        $goods_list_add['freight']=$_POST['freight'];
        $goods_list_add['status']=$_POST['status'];
        $goods_list_add['reorder']=$_POST['reorder'];
        $goods_list_add['text']=$_POST['editorValue'];
        $goods_list_add['imagepath']='';
        $goods_list_add['id']=$_POST['id'];
//        $goods_list_add['id']=Db::name('goods_list')->insertGetId($goods_list_add);
//        dump($goods_list_add);
//        exit;
        $res=new GoodsList;
        $res->isUpdate(true)->save($goods_list_add);
//        dump($res);
//        exit;
        if ($res)
        {
            return $this->success("修改产品信息成功！",'Product/productList',2);
        }
        else
        {
            return $this->error("修改产品信息失败",'Product/productList',2);
        }
    }
    //删除单个产品
        public function product_del()
        {
            $request=Request::instance();
            $id=$request->param();
//            var_dump($id);
//            echo json_encode($id);
//
            $goods_del=Db::name('goods_list')->delete($id);
//            var_dump($goods_del);
            if ($goods_del)
            {

//                echo 1;
                return $this->success("删除产品信息成功！",'Product/productList',2);

            }
            else
            {
//                echo 2;
                return $this->error("删除产品信息失败",'Product/productList',2);
            }
        }
        //批量删除产品
    public function product_del_all()
    {

            $ids=input('post.checkid/a');
            echo json_encode($ids);
//        exit;
        if ($ids)
        {
            echo json_encode($ids);
        }
        else
        {
            echo 2;
        }
    }


//    public function product_add_images()
//    {
//        $upload = new  \org\Upload();// 实例化上传类
//        $upload->maxSize   =     3145728 ;// 设置附件上传大小
//        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
//        $upload->rootPath  =      './static/admin/files/'; // 设置附件上传目录    // 上传文件
//        $upload->saveName=time().rand(1111,9999);
//        $date=date("Y-m-d",time());//已上传日期为子目录名
//        $upload->saveExt="png";//上传的文件后缀
//        $info   =   $upload->upload();
//        if(!$info) {// 上传错误提示错误信息
//
//            $this->error($upload->getError());
//
//        }else{// 上传成功
//
//            $m=M('goods_files');
//            $data['filepath']='/static/admin/files/'.$date."/".$upload->saveName.".".$upload->saveExt;
//            $result=$m->add($data);
//            $file=['id'=>$result,'imagepath'=>$data['filepath']];
//            echo json_encode($file);
//
//        }
//    }

}