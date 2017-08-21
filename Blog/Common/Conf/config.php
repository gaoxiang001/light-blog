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
    'LOAD_EXT_CONFIG'       =>  'router',
    


    'TMPL_ACTION_ERROR'     =>  'Public/error',//错误页面替换
	/* 数据库配置 */
    'DB_TYPE'   => 'mysqli',
    'DB_HOST'   => '101.201.252.66',
    'DB_NAME'   => 'blog',
    'DB_USER'   => 'lvnuo',
    'DB_PWD'    => 'lvnuo2016',
    'DB_PORT'   => '3306',
    'DB_PREFIX' => 't_',

    'DEFAULT_AVATAR' => '/Public/images/avatar.jpg', // 默认头像
    'IMG'            => 'http://img.dian8dian.com/Uploads/', // 图片地址url

    /* slogan*/
    'SLOGAN' => '点8点,让懂得有处发泄',

    /* 跟目录地址 */
    'DOMAIN' => 'http://blog.dian8dian.com',

    /* 禁止申请的二级域名 */
    'SITE'  => [
        'www',
        'file',
        'img',
        'blog',
        'robot',
        'test',
        'bate',
        'gray',
        'release',
        'm'
    ],
);