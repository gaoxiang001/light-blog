<?php
return array(
	//'配置项'=>'配置值'
	'MULTI_MODULE'		=>  false,
	'DEFAULT_MODULE'	=>	'Home',

    // 开启路由
    'URL_MODEL'             =>  2,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
    // 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式
    'URL_PATHINFO_DEPR'     =>  '/',    // PATHINFO模式下，各参数之间的分割符号
    'URL_PATHINFO_FETCH'    =>  'ORIG_PATH_INFO,REDIRECT_PATH_INFO,REDIRECT_URL', // 用于兼容判断PATH_INFO 参数的SERVER替代变量列表
    'URL_REQUEST_URI'       =>  'REQUEST_URI', // 获取当前页面地址的系统变量 默认为REQUEST_URI
    'URL_ROUTER_ON'         =>  true, 
    'URL_HTML_SUFFIX' =>'',//伪静态后缀

    'TMPL_ACTION_ERROR'     =>  'Public/error',//错误页面替换
	/* 数据库配置 */
    'DB_TYPE'   => 'mysqli',
    'DB_HOST'   => '123.56.185.207',
    'DB_NAME'   => 'lvnuo', 
    'DB_USER'   => 'root', 
    'DB_PWD'    => '123456',
    'DB_PORT'   => '3306',
    'DB_PREFIX' => 't_',

    /*装修数据库*/
    'decoration'  =>  array(
        'DB_TYPE'   => 'mysqli',
        'DB_HOST'   => '123.56.185.207',
        'DB_NAME'   => 'decoration', 
        'DB_USER'   => 'root', 
        'DB_PWD'    => '123456',
        'DB_PORT'   => '3306',
        'DB_PREFIX' => 't_',
    ),
);