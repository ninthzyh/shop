<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
define('EXTEND_PATH', '../extend/');
//服务器地址
define("SITE_URL","http://127.0.0.1:7000/shop/public/");

define("PRE_URL","http://127.0.0.1:7000/shop/public/index.php/");
//静态CSS文件地址
define("CSS_URL",SITE_URL."static/admin/css/");
//静态SKIN文件地址
define("SKIN_URL",SITE_URL."static/admin/skin/");

//静态JS文件
define("JS_URL",SITE_URL."static/admin/js/");

//静态图片地址
define("IMG_URL",SITE_URL."static/admin/images/");

//静态LIB文件
define("LIB_URL",SITE_URL."lib/");

//TEMP文件
define("TEMP_URL",SITE_URL."temp/");

//FILEINPUT文件
define("FIL_URL",SITE_URL."fileinput/");

// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';